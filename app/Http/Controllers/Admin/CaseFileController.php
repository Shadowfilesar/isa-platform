<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\InvestigationCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CaseFileController extends Controller
{
    private array $categories = [
        'evidence',
        'photos',
        'reports',
        'documents',
        'audio',
        'video',
        'other',
    ];

    public function index(Request $request, InvestigationCase $case)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        $search = $validated['search'] ?? null;

        $allFiles = $case->files()
            ->orderBy('section')
            ->orderBy('display_order')
            ->orderBy('title')
            ->get();

        $files = $case->files()
            ->when($search, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('title', 'like', '%'.$search.'%')
                        ->orWhere('description', 'like', '%'.$search.'%')
                        ->orWhere('section', 'like', '%'.$search.'%')
                        ->orWhere('category', 'like', '%'.$search.'%')
                        ->orWhere('original_name', 'like', '%'.$search.'%')
                        ->orWhere('mime_type', 'like', '%'.$search.'%')
                        ->orWhere('extension', 'like', '%'.$search.'%');
                });
            })
            ->orderBy('section')
            ->orderBy('display_order')
            ->orderBy('title')
            ->get();

        return view('admin.case-files.index', [
            'case' => $case,
            'files' => $files,
            'sections' => $allFiles
                ->pluck('section')
                ->filter()
                ->unique()
                ->values(),
            'sectionGroups' => $files->groupBy('section'),
            'search' => $search,
            'stats' => [
                'totalFiles' => $allFiles->count(),
                'lockedFiles' => $allFiles->where('locked', true)->count(),
                'unlockedFiles' => $allFiles->where('locked', false)->count(),
                'totalSections' => $allFiles
                    ->pluck('section')
                    ->filter()
                    ->unique()
                    ->count(),
                'lastUpdated' => $allFiles
                    ->sortByDesc('updated_at')
                    ->first()
                    ?->updated_at,
            ],
            'categories' => $this->categories,
        ]);
    }

    public function create(InvestigationCase $case)
    {
        $files = $case->files()
            ->orderBy('section')
            ->orderBy('display_order')
            ->get();

        return view('admin.case-files.create', [
            'case' => $case,
            'sections' => $files
                ->pluck('section')
                ->filter()
                ->unique()
                ->values(),
            'categories' => $this->categories,
            'nextDisplayOrder' => ((int) $files->max('display_order')) + 1,
        ]);
    }

    public function store(Request $request, InvestigationCase $case)
    {
        $validated = $this->validateFileRequest($request, true);

        $uploadedFile = $request->file('file');
        $path = $uploadedFile->store('case-files', 'public');

        CaseFile::create([
            'case_id' => $case->id,
            'category' => $validated['category'],
            'section' => $validated['section'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_name' => basename($path),
            'original_name' => $uploadedFile->getClientOriginalName(),
            'mime_type' => $uploadedFile->getMimeType(),
            'file_size' => $uploadedFile->getSize(),
            'extension' => $uploadedFile->extension(),
            'file_path' => 'storage/'.$path,
            'display_order' => $validated['display_order'],
            'locked' => $request->boolean('locked'),
            'public' => $request->boolean('public'),
            'unlock_event' => $validated['unlock_event'] ?? null,
            'required_rank' => $validated['required_rank'] ?? null,
            'required_clearance' => $validated['required_clearance'] ?? null,
            'uploaded_by' => auth('admin')->id(),
            'updated_by' => auth('admin')->id(),
            'preview_count' => 0,
            'download_count' => 0,
            'sha256' => hash_file('sha256', $uploadedFile->getRealPath()),
            'parent_file_id' => null,
            'version' => 1,
            'is_current' => true,
        ]);

        return redirect()
            ->route('admin.case-files.index', $case)
            ->with('success', 'File uploaded.');
    }

    public function edit(InvestigationCase $case, CaseFile $file)
    {
        $this->ensureFileBelongsToCase($case, $file);

        $files = $case->files()
            ->where('id', '!=', $file->id)
            ->orderBy('section')
            ->orderBy('display_order')
            ->get();

        return view('admin.case-files.edit', [
            'case' => $case,
            'file' => $file,
            'sections' => $files
                ->pluck('section')
                ->filter()
                ->push($file->section)
                ->filter()
                ->unique()
                ->values(),
            'categories' => $this->categories,
        ]);
    }

    public function update(Request $request, InvestigationCase $case, CaseFile $file)
    {
        $this->ensureFileBelongsToCase($case, $file);

        $validated = $this->validateFileRequest($request, false);

        $attributes = [
            'category' => $validated['category'],
            'section' => $validated['section'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'display_order' => $validated['display_order'],
            'locked' => $request->boolean('locked'),
            'public' => $request->boolean('public'),
            'unlock_event' => $validated['unlock_event'] ?? null,
            'required_rank' => $validated['required_rank'] ?? null,
            'required_clearance' => $validated['required_clearance'] ?? null,
            'updated_by' => auth('admin')->id(),
        ];

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');

            $this->deleteStoredFile($file);

            $path = $uploadedFile->store('case-files', 'public');

            $attributes = array_merge($attributes, [
                'file_name' => basename($path),
                'original_name' => $uploadedFile->getClientOriginalName(),
                'mime_type' => $uploadedFile->getMimeType(),
                'file_size' => $uploadedFile->getSize(),
                'extension' => $uploadedFile->extension(),
                'file_path' => 'storage/'.$path,
                'sha256' => hash_file('sha256', $uploadedFile->getRealPath()),
            ]);
        }

        $file->update($attributes);

        return redirect()
            ->route('admin.case-files.index', $case)
            ->with('success', 'File updated.');
    }

    public function destroy(InvestigationCase $case, CaseFile $file)
    {
        $this->ensureFileBelongsToCase($case, $file);

        $this->deleteStoredFile($file);

        $file->delete();

        return redirect()
            ->route('admin.case-files.index', $case)
            ->with('success', 'File deleted.');
    }

    public function reorder(Request $request, InvestigationCase $case)
    {
        $validated = $request->validate([
            'files' => ['required', 'array'],
            'files.*.id' => [
                'required',
                'integer',
                Rule::exists('case_files', 'id')
                    ->where(fn ($query) => $query->where('case_id', $case->id)),
            ],
            'files.*.display_order' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($validated['files'] as $fileOrder) {
            $case->files()
                ->where('id', $fileOrder['id'])
                ->update([
                    'display_order' => $fileOrder['display_order'],
                    'updated_by' => auth('admin')->id(),
                ]);
        }

        return redirect()
            ->route('admin.case-files.index', $case)
            ->with('success', 'File order updated.');
    }

    public function toggleLock(InvestigationCase $case, CaseFile $file)
    {
        $this->ensureFileBelongsToCase($case, $file);

        $wasLocked = (bool) $file->locked;

        $file->update([
            'locked' => ! $wasLocked,
            'updated_by' => auth('admin')->id(),
        ]);

        return redirect()
            ->route('admin.case-files.index', $case)
            ->with('success', $wasLocked ? 'File unlocked.' : 'File locked.');
    }

    private function validateFileRequest(Request $request, bool $fileRequired): array
    {
        return $request->validate([
            'section' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['required', Rule::in($this->categories)],
            'display_order' => ['required', 'integer', 'min:0'],
            'locked' => ['nullable', 'boolean'],
            'public' => ['nullable', 'boolean'],
            'unlock_event' => ['nullable', 'string', 'max:255'],
            'required_rank' => ['nullable', 'string', 'max:255'],
            'required_clearance' => ['nullable', 'string', 'max:255'],
            'file' => [
                $fileRequired ? 'required' : 'nullable',
                'file',
                'max:102400',
            ],
        ]);
    }

    private function ensureFileBelongsToCase(InvestigationCase $case, CaseFile $file): void
    {
        abort_if($file->case_id !== $case->id, 404);
    }

    private function deleteStoredFile(CaseFile $file): void
    {
        $path = $this->publicStoragePath($file);

        if ($path !== '') {
            Storage::disk('public')->delete($path);
        }
    }

    private function publicStoragePath(CaseFile $file): string
    {
        return str($file->file_path)
            ->replaceStart('storage/', '')
            ->toString();
    }
}