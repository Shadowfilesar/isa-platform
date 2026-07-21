<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\InvestigationCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CaseFileController extends Controller
{
    private array $categories = [
        'Mission',
        'Evidence',
        'Document',
        'Report',
        'Audio',
        'Video',
        'Image',
        'Archive',
        'Transcript',
        'Reference',
    ];

    public function index(InvestigationCase $case)
    {
        $files = $case->files()
            ->with(['uploader', 'updater', 'parent'])
            ->orderBy('section')
            ->orderBy('display_order')
            ->orderByDesc('version')
            ->get();

        $sections = $case->files()
            ->whereNotNull('section')
            ->where('section', '!=', '')
            ->orderBy('section')
            ->pluck('section')
            ->unique()
            ->values();

        $categories = $case->files()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->orderBy('category')
            ->pluck('category')
            ->unique()
            ->values();

        return view('admin.case-files.index', [
            'case' => $case,
            'files' => $files,
            'sections' => $sections,
            'categories' => $categories,
        ]);
    }

    public function create(InvestigationCase $case)
    {
        $sections = $case->files()
            ->whereNotNull('section')
            ->where('section', '!=', '')
            ->orderBy('section')
            ->pluck('section')
            ->unique()
            ->values();

        $nextDisplayOrder = ((int) $case->files()->max('display_order')) + 1;

        return view('admin.case-files.create', [
            'case' => $case,
            'sections' => $sections,
            'categories' => $this->categories,
            'nextDisplayOrder' => $nextDisplayOrder > 0 ? $nextDisplayOrder : 1,
        ]);
    }

    public function store(Request $request, InvestigationCase $case)
    {
        $validated = $request->validate([
            'section' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'display_order' => ['required', 'integer', 'min:1'],
            'locked' => ['nullable', 'boolean'],
            'public' => ['nullable', 'boolean'],
            'unlock_event' => ['nullable', 'string', 'max:255'],
            'required_rank' => ['nullable', 'string', 'max:255'],
            'required_clearance' => ['nullable', 'string', 'max:255'],
            'file' => ['required', 'file', 'max:102400'],
        ]);

        $uploadedFile = $request->file('file');
        $storedPath = $uploadedFile->store('case-files', 'public');
        $absolutePath = Storage::disk('public')->path($storedPath);

        $originalName = $uploadedFile->getClientOriginalName();
        $extension = strtolower($uploadedFile->getClientOriginalExtension() ?: $uploadedFile->extension() ?: '');
        $mimeType = $uploadedFile->getMimeType() ?: $uploadedFile->getClientMimeType() ?: 'application/octet-stream';
        $fileSize = (int) $uploadedFile->getSize();
        $hash = is_file($absolutePath) ? hash_file('sha256', $absolutePath) : null;

        $adminId = auth('admin')->id();

        CaseFile::create([
            'case_id' => $case->id,
            'section' => $validated['section'],
            'category' => $validated['category'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_name' => pathinfo($storedPath, PATHINFO_BASENAME),
            'original_name' => $originalName,
            'mime_type' => $mimeType,
            'file_size' => $fileSize,
            'extension' => $extension,
            'file_path' => 'storage/' . $storedPath,
            'display_order' => $validated['display_order'],
            'locked' => $request->boolean('locked'),
            'public' => $request->boolean('public'),
            'unlock_event' => $validated['unlock_event'] ?? null,
            'required_rank' => $validated['required_rank'] ?? null,
            'required_clearance' => $validated['required_clearance'] ?? null,
            'uploaded_by' => $adminId,
            'updated_by' => $adminId,
            'preview_count' => 0,
            'download_count' => 0,
            'sha256' => $hash,
            'parent_file_id' => null,
            'version' => 1,
            'is_current' => true,
        ]);

        return redirect()
            ->route('admin.case-files.index', $case)
            ->with('success', 'File uploaded successfully.');
    }

    public function show(InvestigationCase $case, CaseFile $file): StreamedResponse|BinaryFileResponse
    {
        $this->ensureBelongsToCase($case, $file);

        $path = $this->diskPath($file->file_path);

        abort_unless(Storage::disk('public')->exists($path), 404);

        $file->increment('download_count');

        return Storage::disk('public')->download(
            $path,
            $file->original_name ?: $file->file_name ?: basename($path)
        );
    }

    public function edit(InvestigationCase $case, CaseFile $file)
    {
        $this->ensureBelongsToCase($case, $file);

        $sections = $case->files()
            ->whereNotNull('section')
            ->where('section', '!=', '')
            ->orderBy('section')
            ->pluck('section')
            ->unique()
            ->values();

        return view('admin.case-files.edit', [
            'case' => $case,
            'file' => $file,
            'sections' => $sections,
            'categories' => $this->categories,
        ]);
    }

    public function update(Request $request, InvestigationCase $case, CaseFile $file)
    {
        $this->ensureBelongsToCase($case, $file);

        $validated = $request->validate([
            'section' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'display_order' => ['required', 'integer', 'min:1'],
            'locked' => ['nullable', 'boolean'],
            'public' => ['nullable', 'boolean'],
            'unlock_event' => ['nullable', 'string', 'max:255'],
            'required_rank' => ['nullable', 'string', 'max:255'],
            'required_clearance' => ['nullable', 'string', 'max:255'],
            'file' => ['nullable', 'file', 'max:102400'],
        ]);

        $data = [
            'section' => $validated['section'],
            'category' => $validated['category'],
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
            $storedPath = $uploadedFile->store('case-files', 'public');
            $absolutePath = Storage::disk('public')->path($storedPath);

            $oldPath = $this->diskPath($file->file_path);
            if ($oldPath !== '' && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            $data['file_name'] = pathinfo($storedPath, PATHINFO_BASENAME);
            $data['original_name'] = $uploadedFile->getClientOriginalName();
            $data['mime_type'] = $uploadedFile->getMimeType() ?: $uploadedFile->getClientMimeType() ?: 'application/octet-stream';
            $data['file_size'] = (int) $uploadedFile->getSize();
            $data['extension'] = strtolower($uploadedFile->getClientOriginalExtension() ?: $uploadedFile->extension() ?: '');
            $data['file_path'] = 'storage/' . $storedPath;
            $data['sha256'] = is_file($absolutePath) ? hash_file('sha256', $absolutePath) : null;
        }

        $file->update($data);

        return redirect()
            ->route('admin.case-files.index', $case)
            ->with('success', 'File updated successfully.');
    }

    public function destroy(InvestigationCase $case, CaseFile $file)
    {
        $this->ensureBelongsToCase($case, $file);

        $path = $this->diskPath($file->file_path);

        if ($path !== '' && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $file->delete();

        return redirect()
            ->route('admin.case-files.index', $case)
            ->with('success', 'File deleted successfully.');
    }

    public function reorder(Request $request, InvestigationCase $case)
    {
        $validated = $request->validate([
            'files' => ['required', 'array', 'min:1'],
            'files.*.id' => [
                'required',
                'integer',
                Rule::exists('case_files', 'id')->where(function ($query) use ($case) {
                    $query->where('case_id', $case->id);
                }),
            ],
            'files.*.display_order' => ['required', 'integer', 'min:1'],
        ]);

        foreach ($validated['files'] as $item) {
            $case->files()
                ->where('id', $item['id'])
                ->update([
                    'display_order' => $item['display_order'],
                    'updated_by' => auth('admin')->id(),
                ]);
        }

        return redirect()
            ->route('admin.case-files.index', $case)
            ->with('success', 'File order updated successfully.');
    }

    public function toggleLock(InvestigationCase $case, CaseFile $file)
    {
        $this->ensureBelongsToCase($case, $file);

        $file->update([
            'locked' => ! $file->locked,
            'updated_by' => auth('admin')->id(),
        ]);

        return redirect()
            ->route('admin.case-files.index', $case)
            ->with('success', $file->locked ? 'File locked successfully.' : 'File unlocked successfully.');
    }

    private function ensureBelongsToCase(InvestigationCase $case, CaseFile $file): void
    {
        abort_if($file->case_id !== $case->id, 404);
    }

    private function diskPath(?string $filePath): string
    {
        $path = (string) $filePath;

        if (Str::startsWith($path, 'storage/')) {
            return Str::after($path, 'storage/');
        }

        return ltrim($path, '/');
    }
}