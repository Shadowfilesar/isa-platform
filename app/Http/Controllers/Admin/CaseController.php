<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestigationCase;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function index()
    {
        return view('admin.cases.index', [

            'cases' => InvestigationCase::query()
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

            'code' => ['required','max:50','unique:cases,code'],

            'title' => ['required','max:255'],

            'description' => ['nullable'],

            'difficulty' => ['required'],

            'published' => ['nullable'],

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

            ->with('success','Case created successfully.');

    }

    public function edit(InvestigationCase $case)
    {
        return view('admin.cases.edit', [

            'case' => $case,

        ]);
    }

    public function update(
        Request $request,
        InvestigationCase $case
    )
    {
        $validated = $request->validate([

            'code' => 'required|max:50|unique:cases,code,'.$case->id,

            'title' => 'required|max:255',

            'description' => 'nullable',

            'difficulty' => 'required',

            'published' => 'nullable',

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

            ->with('success','Case updated.');

    }

    public function destroy(
        InvestigationCase $case
    )
    {
        $case->delete();

        return back()->with(

            'success',

            'Case deleted.'

        );
    }
}