@extends('layouts.admin')

@section('title','Investigation Cases')

@section('content')

<div class="p-10">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold text-white">
                Investigation Cases
            </h1>
            <p class="text-slate-400 mt-2">
                ISA Case Management
            </p>
        </div>

        <a
            href="{{ route('admin.cases.create') }}"
            class="rounded-lg bg-amber-600 hover:bg-amber-500 px-6 py-3 text-white">
            + New Case
        </a>
    </div>

    <div class="executive-card overflow-hidden rounded-xl">
        <table class="w-full">
            <thead class="bg-slate-900">
                <tr>
                    <th class="text-left p-4">Code</th>
                    <th class="text-left p-4">Title</th>
                    <th class="text-left p-4">Difficulty</th>
                    <th class="text-left p-4">Files</th>
                    <th class="text-left p-4">Status</th>
                    <th class="text-right p-4">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($cases as $case)
                <tr class="border-t border-slate-800">
                    <td class="p-4">
                        {{ $case->code }}
                    </td>

                    <td class="p-4">
                        <div class="font-semibold text-white">
                            {{ $case->title }}
                        </div>
                        @if($case->description)
                            <div class="text-sm text-slate-500 mt-1">
                                {{ \Illuminate\Support\Str::limit($case->description, 100) }}
                            </div>
                        @endif
                    </td>

                    <td class="p-4">
                        {{ $case->difficulty }}
                    </td>

                    <td class="p-4">
                        {{ $case->files_count }}
                    </td>

                    <td class="p-4">
                        @if($case->published)
                            <span class="text-green-400">
                                Published
                            </span>
                        @else
                            <span class="text-yellow-400">
                                Draft
                            </span>
                        @endif
                    </td>

                    <td class="p-4">
                        <div class="flex justify-end gap-3">
                            <a
                                href="{{ route('admin.case-files.index',$case) }}"
                                class="rounded bg-slate-800 px-4 py-2 text-white">
                                Files
                            </a>

                            <a
                                href="{{ route('admin.cases.edit',$case) }}"
                                class="rounded bg-amber-600 px-4 py-2 text-white">
                                Edit
                            </a>

                            <form
                                action="{{ route('admin.cases.destroy',$case) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this case and all related files?')">
                                @csrf
                                @method('DELETE')

                                <button
                                    class="rounded bg-red-700 px-4 py-2 text-white">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-10 text-slate-500">
                        No investigations created yet.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $cases->links() }}
    </div>
</div>

@endsection