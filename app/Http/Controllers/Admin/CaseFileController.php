<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\InvestigationCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CaseFileController extends Controller
{
    private array $fileTypes = [
        'pdf',
        'image',
        'video',
        'audio',
        'text',
        'document',
        'archive',
    ];

    public function index(
        Request $request,
        InvestigationCase $case
    )
    {
        $validated = $request->validate([

            'search' => ['nullable','string','max:255'],

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
                        ->orWhere('file_type', 'like', '%'.$search.'%');
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

                'lockedFiles' => $allFiles
                    ->where('locked', true)
                    ->count(),

                'unlockedFiles' => $allFiles
                    ->where('locked', false)
                    ->count(),

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

            'fileTypes' => $this->fileTypes,

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

            'fileTypes' => $this->fileTypes,

            'nextDisplayOrder' => ((int) $files->max('display_order')) + 1,

        ]);
    }

    public function store(
        Request $request,
        InvestigationCase $case
    ) {

        $validated = $request->validate([

            'section' => ['required','max:100'],

            'title' => ['required','max:255'],

            'description' => ['nullable'],

            'file_type' => ['required', Rule::in($this->fileTypes)],

            'display_order' => ['required','integer'],

            'locked' => ['nullable'],

            'file' => [
                'required',
                'file',
                'max:102400'
            ],

        ]);

        $this->validateFileTypeMatchesMime(
            $validated['file_type'],
            $request->file('file')->getMimeType()
        );

        $path = $request
            ->file('file')
            ->store(
                'case-files',
                'public'
            );

        CaseFile::create([

            'case_id' => $case->id,

            'section' => $validated['section'],

            'title' => $validated['title'],

            'description' => $validated['description'] ?? null,

            'file_type' => $validated['file_type'],

            'display_order' => $validated['display_order'],

            'locked' => $request->boolean('locked'),

            'file_path' => 'storage/'.$path,

        ]);

        return redirect()

            ->route(
                'admin.case-files.index',
                $case
            )

            ->with(
                'success',
                'File uploaded.'
            );
    }

    public function edit(
        InvestigationCase $case,
        CaseFile $file
    ) {
        $this->ensureFileBelongsToCase(
            $case,
            $file
        );

        $files = $case->files()
            ->orderBy('section')
            ->orderBy('display_order')
            ->get();

        return view('admin.case-files.edit', [

            'case' => $case,

            'file' => $file,

            'sections' => $files
                ->pluck('section')
                ->filter()
                ->unique()
                ->values(),

            'fileTypes' => $this->fileTypes,

        ]);
    }

    public function update(
        Request $request,
        InvestigationCase $case,
        CaseFile $file
    ) {
        $this->ensureFileBelongsToCase(
            $case,
            $file
        );

        $validated = $request->validate([

            'section' => ['required','max:100'],

            'title' => ['required','max:255'],

            'description' => ['nullable'],

            'file_type' => ['required', Rule::in($this->fileTypes)],

            'display_order' => ['required','integer'],

            'locked' => ['nullable'],

            'file' => [
                'nullable',
                'file',
                'max:102400'
            ],

        ]);

        $filePath = $file->file_path;

        if ($request->hasFile('file')) {

            $this->validateFileTypeMatchesMime(
                $validated['file_type'],
                $request->file('file')->getMimeType()
            );

            $this->deleteStoredFile($file);

            $path = $request
                ->file('file')
                ->store(
                    'case-files',
                    'public'
                );

            $filePath = 'storage/'.$path;
        }

        $file->update([

            'section' => $validated['section'],

            'title' => $validated['title'],

            'description' => $validated['description'] ?? null,

            'file_type' => $validated['file_type'],

            'display_order' => $validated['display_order'],

            'locked' => $request->boolean('locked'),

            'file_path' => $filePath,

        ]);

        return redirect()

            ->route(
                'admin.case-files.index',
                $case
            )

            ->with(
                'success',
                'File updated.'
            );
    }

    public function destroy(
        InvestigationCase $case,
        CaseFile $file
    ) {
        $this->ensureFileBelongsToCase(
            $case,
            $file
        );

        $this->deleteStoredFile($file);

        $file->delete();

        return redirect()

            ->route(
                'admin.case-files.index',
                $case
            )

            ->with(
                'success',
                'File deleted.'
            );
    }

    public function reorder(
        Request $request,
        InvestigationCase $case
    ) {
        $validated = $request->validate([

            'files' => ['required','array'],

            'files.*.id' => [
                'required',
                'integer',
                Rule::exists('case_files','id')
                    ->where(fn ($query) => $query->where('case_id', $case->id)),
            ],

            'files.*.display_order' => ['required','integer'],

        ]);

        foreach ($validated['files'] as $fileOrder) {

            $case->files()
                ->where('id', $fileOrder['id'])
                ->update([
                    'display_order' => $fileOrder['display_order'],
                ]);
        }

        return redirect()

            ->route(
                'admin.case-files.index',
                $case
            )

            ->with(
                'success',
                'File order updated.'
            );
    }

    public function toggleLock(
        InvestigationCase $case,
        CaseFile $file
    ) {
        $this->ensureFileBelongsToCase(
            $case,
            $file
        );

        $file->update([
            'locked' => ! $file->locked,
        ]);

        return redirect()

            ->route(
                'admin.case-files.index',
                $case
            )

            ->with(
                'success',
                $file->locked ? 'File locked.' : 'File unlocked.'
            );
    }

    private function ensureFileBelongsToCase(
        InvestigationCase $case,
        CaseFile $file
    ): void {
        abort_if(
            $file->case_id !== $case->id,
            404
        );
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

    private function validateFileTypeMatchesMime(
        string $fileType,
        ?string $mimeType
    ): void {
        if (! $mimeType || ! $this->mimeMatchesFileType($fileType, $mimeType)) {

            throw ValidationException::withMessages([
                'file' => 'The uploaded file does not match the selected file type.',
            ]);
        }
    }

    private function mimeMatchesFileType(
        string $fileType,
        string $mimeType
    ): bool {
        return match ($fileType) {
            'pdf' => $mimeType === 'application/pdf',
            'image' => str_starts_with($mimeType, 'image/'),
            'video' => str_starts_with($mimeType, 'video/'),
            'audio' => str_starts_with($mimeType, 'audio/'),
            'text' => str_starts_with($mimeType, 'text/')
                || in_array($mimeType, [
                    'application/json',
                    'application/xml',
                ], true),
            'document' => in_array($mimeType, [
                'application/msword',
                'application/rtf',
                'application/vnd.ms-excel',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.oasis.opendocument.presentation',
                'application/vnd.oasis.opendocument.spreadsheet',
                'application/vnd.oasis.opendocument.text',
            ], true),
            'archive' => in_array($mimeType, [
                'application/gzip',
                'application/java-archive',
                'application/vnd.rar',
                'application/x-7z-compressed',
                'application/x-bzip2',
                'application/x-gzip',
                'application/x-rar-compressed',
                'application/zip',
            ], true),
            default => false,
        };
    }
}
