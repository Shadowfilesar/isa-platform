<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestigationCase;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CaseController extends Controller
{
    /**
     * Display all investigation cases.
     */
    public function index()
    {
        $cases = InvestigationCase::query()
            ->latest()
            ->paginate(15);

        return view('admin.cases.index', [
            'cases' => $cases,
        ]);
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.cases.create');
    }

    /**
     * Store a newly created investigation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'code' => [
                'required',
                'string',
                'max:50',
                'unique:cases,code',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'difficulty' => [
                'required',
                Rule::in([
                    'Easy',
                    'Medium',
                    'Hard',
                ]),
            ],

            'published' => [
                'nullable',
                'boolean',
            ],

        ]);

        $case = InvestigationCase::create([

            'code' => strtoupper($validated['code']),

            'title' => $validated['title'],

            'description' => $validated['description'] ?? null,

            'difficulty' => $validated['difficulty'],

            'published' => $request->boolean('published'),

            'cover_image' => null,

        ]);

        return redirect()

            ->route('admin.cases.index')

            ->with(
                'success',
                'Investigation created successfully.'
            );
    }
        /**
     * Display a single investigation.
     */
    public function show(InvestigationCase $case)
    {
        return redirect()->route(
            'admin.case-files.index',
            $case
        );
    }

    /**
     * Show edit form.
     */
    public function edit(InvestigationCase $case)
    {
        return view('admin.cases.edit', [
            'case' => $case,
        ]);
    }

    /**
     * Update an investigation.
     */
    public function update(
        Request $request,
        InvestigationCase $case
    ) {
        $validated = $request->validate([

            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('cases', 'code')
                    ->ignore($case->id),
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'difficulty' => [
                'required',
                Rule::in([
                    'Easy',
                    'Medium',
                    'Hard',
                ]),
            ],

            'published' => [
                'nullable',
                'boolean',
            ],

        ]);

        $case->update([

            'code' => strtoupper($validated['code']),

            'title' => $validated['title'],

            'description' => $validated['description'] ?? null,

            'difficulty' => $validated['difficulty'],

            'published' => $request->boolean('published'),

        ]);

        return redirect()

            ->route('admin.cases.index')

            ->with(
                'success',
                'Investigation updated successfully.'
            );
    }

    /**
     * Delete an investigation.
     */
    public function destroy(InvestigationCase $case)
    {
        if ($case->files()->exists()) {

            return redirect()

                ->route('admin.cases.index')

                ->with(
                    'error',
                    'Delete all case files before deleting this investigation.'
                );
        }

        $case->delete();

        return redirect()

            ->route('admin.cases.index')

            ->with(
                'success',
                'Investigation deleted successfully.'
            );
    }
}