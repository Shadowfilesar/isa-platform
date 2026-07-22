@extends('layouts.admin')

@section('title','Cases')

@section('content')
<div class="p-10">
    <div class="mb-8 flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
        <div>
            <a
                href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-700 bg-slate-900 px-5 py-3 text-white transition hover:border-amber-500">
                Dashboard
            </a>

            <div class="mt-5 text-sm text-slate-500">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-white">Dashboard</a>
                <span class="mx-2">/</span>
                <span class="text-amber-400">Cases</span>
            </div>

            <h1 class="mt-6 text-4xl font-bold text-white">
                Case Management
            </h1>

            <p class="mt-2 text-slate-500">
                Manage investigation cases, publication status, and file readiness.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a
                href="{{ route('admin.cases.create') }}"
                class="rounded-lg bg-amber-600 px-6 py-3 font-semibold text-white transition hover:bg-amber-500">
                + Create Case
            </a>
        </div>
    </div>

    <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="executive-card executive-glow p-6">
            <p class="text-slate-500">Total Cases</p>
            <div class="mt-3 text-4xl font-bold text-white">
                {{ $cases->total() }}
            </div>
        </div>

        <div class="executive-card executive-glow p-6">
            <p class="text-slate-500">Published Cases</p>
            <div class="mt-3 text-4xl font-bold text-green-400">
                {{ $cases->getCollection()->where('published', true)->count() }}
            </div>
        </div>

        <div class="executive-card executive-glow p-6">
            <p class="text-slate-500">Draft Cases</p>
            <div class="mt-3 text-4xl font-bold text-amber-400">
                {{ $cases->getCollection()->where('published', false)->count() }}
            </div>
        </div>

        <div class="executive-card executive-glow p-6">
            <p class="text-slate-500">Files In View</p>
            <div class="mt-3 text-4xl font-bold text-blue-400">
                {{ $cases->getCollection()->sum('files_count') }}
            </div>
        </div>
    </div>

    <div class="mb-8 grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="executive-card p-6 xl:col-span-2">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">Search</h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Search is not connected in the current backend, so this section is presentation-only.
                    </p>
                </div>

                <div class="flex w-full max-w-xl gap-3">
                    <input
                        type="text"
                        placeholder="Search by case code or title..."
                        class="isa-input">
                    <button
                        type="button"
                        class="rounded-lg border border-slate-700 bg-slate-900 px-5 py-3 font-semibold text-white transition hover:border-amber-500">
                        Search
                    </button>
                </div>
            </div>
        </div>

        <div class="executive-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">Filters</h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Backend-neutral visual filter summary.
                    </p>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap gap-3">
                <span class="rounded-full bg-slate-900 px-4 py-2 text-sm text-slate-300">All Difficulties</span>
                <span class="rounded-full bg-green-900/50 px-4 py-2 text-sm text-green-300">Published</span>
                <span class="rounded-full bg-amber-900/50 px-4 py-2 text-sm text-amber-300">Draft</span>
            </div>
        </div>
    </div>

    <div class="executive-card overflow-hidden">
        <div class="border-b border-slate-800 bg-slate-900/70 px-6 py-5">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">Investigation Cases</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Full case registry with publication status and file totals.
                    </p>
                </div>

                <div class="rounded-lg border border-slate-800 bg-slate-950/60 px-4 py-2 text-sm text-slate-400">
                    Showing {{ $cases->count() }} of {{ $cases->total() }} cases
                </div>
            </div>
        </div>

        @if($cases->count())
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-950/80">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">
                                Case
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">
                                Difficulty
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">
                                Files
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">
                                Created
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-widest text-slate-500">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($cases as $case)
                            <tr class="border-t border-slate-800 align-top transition hover:bg-slate-900/40">
                                <td class="px-6 py-5">
                                    <div class="font-semibold text-white">
                                        {{ $case->title }}
                                    </div>
                                    <div class="mt-1 text-sm text-amber-400">
                                        {{ $case->code }}
                                    </div>
                                    <div class="mt-2 max-w-xl text-sm leading-6 text-slate-400">
                                        {{ $case->description ?: 'No case description provided.' }}
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    @if($case->difficulty === 'Hard')
                                        <span class="rounded-full bg-red-900 px-3 py-1 text-sm font-semibold text-red-300">
                                            {{ $case->difficulty }}
                                        </span>
                                    @elseif($case->difficulty === 'Medium')
                                        <span class="rounded-full bg-amber-900 px-3 py-1 text-sm font-semibold text-amber-300">
                                            {{ $case->difficulty }}
                                        </span>
                                    @else
                                        <span class="rounded-full bg-green-900 px-3 py-1 text-sm font-semibold text-green-300">
                                            {{ $case->difficulty }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    @if($case->published)
                                        <span class="rounded-full bg-green-900 px-3 py-1 text-sm font-semibold text-green-300">
                                            Published
                                        </span>
                                    @else
                                        <span class="rounded-full bg-slate-800 px-3 py-1 text-sm font-semibold text-slate-300">
                                            Draft
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    <div class="font-semibold text-white">
                                        {{ $case->files_count }}
                                    </div>
                                    <div class="mt-1 text-sm text-slate-500">
                                        attached files
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="text-sm font-medium text-white">
                                        {{ optional($case->created_at)->format('Y-m-d') ?? '-' }}
                                    </div>
                                    <div class="mt-1 text-sm text-slate-500">
                                        {{ optional($case->created_at)->format('H:i') ?? '' }}
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex flex-wrap justify-end gap-3">
                                        <a
                                            href="{{ route('admin.case-files.index', $case) }}"
                                            class="rounded-lg bg-blue-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-600">
                                            Files
                                        </a>

                                        <a
                                            href="{{ route('admin.cases.edit', $case) }}"
                                            class="rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-500">
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.cases.destroy', $case) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this case?')">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-red-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-600">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-20 text-center">
                <div class="mx-auto max-w-lg">
                    <div class="text-5xl">📁</div>
                    <h3 class="mt-6 text-2xl font-bold text-white">
                        No investigation cases found
                    </h3>
                    <p class="mt-3 text-slate-500">
                        No cases have been created yet in this environment.
                    </p>
                    <div class="mt-8">
                        <a
                            href="{{ route('admin.cases.create') }}"
                            class="rounded-lg bg-amber-600 px-6 py-3 font-semibold text-white transition hover:bg-amber-500">
                            Create First Case
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="mt-8">
        {{ $cases->links() }}
    </div>
</div>
@endsection