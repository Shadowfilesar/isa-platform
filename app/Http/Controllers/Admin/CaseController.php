<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestigationCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CaseController extends Controller
{
    public function index()
    {
        return view('admin.cases.index', [
            'cases' => InvestigationCase::query()
                ->withCount('files')
                ->latest()
                ->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.cases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:cases,code'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'difficulty' => ['required', 'string', Rule::in(['Easy', 'Medium', 'Hard'])],
            'published' => ['nullable', 'boolean'],
        ]);

        InvestigationCase::create([
            'code' => $validated['code'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'difficulty' => $validated['difficulty'],
            'published' => $request->boolean('published'),
        ]);

        return redirect()
            ->route('admin.cases.index')
            ->with('success', 'Case created successfully.');
    }

    public function edit(InvestigationCase $case)
    {
        return view('admin.cases.edit', [
            'case' => $case,
        ]);
    }

    public function update(Request $request, InvestigationCase $case)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('cases', 'code')->ignore($case->id)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'difficulty' => ['required', 'string', Rule::in(['Easy', 'Medium', 'Hard'])],
            'published' => ['nullable', 'boolean'],
        ]);

        $case->update([
            'code' => $validated['code'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'difficulty' => $validated['difficulty'],
            'published' => $request->boolean('published'),
        ]);

        return redirect()
            ->route('admin.cases.index')
            ->with('success', 'Case updated successfully.');
    }

    public function destroy(InvestigationCase $case)
    {
        DB::transaction(function () use ($case) {
            $case->files->each(function ($file) {
                $path = $this->publicStoragePath($file->file_path);

                if ($path !== '') {
                    Storage::disk('public')->delete($path);
                }
            });

            $case->delete();
        });

        return redirect()
            ->route('admin.cases.index')
            ->with('success', 'Case deleted successfully.');
    }

    private function publicStoragePath(?string $filePath): string
    {
        return str((string) $filePath)
            ->replaceStart('storage/', '')
            ->toString();
    }
}