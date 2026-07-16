@extends('layouts.admin')

@section('title','Investigation Cases')

@section('content')

<div class="p-10">

    <div class="mb-8">

        <div class="flex items-center justify-between">

            <div>

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-slate-700 bg-slate-900 px-5 py-3 text-white hover:border-amber-500">

                    ← Dashboard

                </a>

                <div class="mt-5 text-sm text-slate-500">

                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="hover:text-white">

                        Dashboard

                    </a>

                    <span class="mx-2">/</span>

                    <span class="text-amber-400">

                        Investigation Cases

                    </span>

                </div>

            </div>

            <a
                href="{{ route('admin.cases.create') }}"
                class="rounded-lg bg-amber-600 px-6 py-3 font-semibold text-white hover:bg-amber-500">

                + New Investigation

            </a>

        </div>

    </div>

    <div class="executive-card p-6 mb-8">

        <form
            method="GET"
            class="grid gap-4 md:grid-cols-4">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search case..."
                class="isa-input">

            <select
                name="difficulty"
                class="isa-input">

                <option value="">

                    All Difficulties

                </option>

                <option value="Easy">

                    Easy

                </option>

                <option value="Medium">

                    Medium

                </option>

                <option value="Hard">

                    Hard

                </option>

            </select>

            <select
                name="status"
                class="isa-input">

                <option value="">

                    All Status

                </option>

                <option value="published">

                    Published

                </option>

                <option value="draft">

                    Draft

                </option>

            </select>

            <button
                class="rounded-lg bg-slate-800 px-6 py-3 font-semibold text-white hover:bg-slate-700">

                Search

            </button>

        </form>

    </div>

    <div class="executive-card overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-900">

                <tr>

                    <th class="p-4 text-left">

                        Code

                    </th>

                    <th class="p-4 text-left">

                        Investigation

                    </th>

                    <th class="p-4 text-left">

                        Difficulty

                    </th>

                    <th class="p-4 text-left">

                        Status

                    </th>

                    <th class="p-4 text-right">

                        Actions

                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse($cases as $case)
                            <tr class="border-t border-slate-800 hover:bg-slate-900/40">

                    <td class="p-4 font-semibold text-white">

                        {{ $case->code }}

                    </td>

                    <td class="p-4">

                        <div class="font-semibold text-white">

                            {{ $case->title }}

                        </div>

                        <div class="mt-1 text-sm text-slate-500">

                            {{ \Illuminate\Support\Str::limit($case->description,80) }}

                        </div>

                    </td>

                    <td class="p-4">

                        <span class="rounded-full bg-slate-800 px-3 py-1 text-sm">

                            {{ $case->difficulty }}

                        </span>

                    </td>

                    <td class="p-4">

                        @if($case->published)

                            <span class="rounded-full bg-green-900 px-3 py-1 text-sm text-green-300">

                                Published

                            </span>

                        @else

                            <span class="rounded-full bg-yellow-900 px-3 py-1 text-sm text-yellow-300">

                                Draft

                            </span>

                        @endif

                    </td>

                    <td class="p-4">

                        <div class="flex justify-end gap-3">

                            <a
                                href="{{ route('admin.case-files.index',$case) }}"
                                class="rounded-lg bg-slate-800 px-4 py-2 text-white hover:bg-slate-700">

                                Files

                            </a>

                            <a
                                href="{{ route('admin.cases.edit',$case) }}"
                                class="rounded-lg bg-amber-600 px-4 py-2 text-white hover:bg-amber-500">

                                Edit

                            </a>

                            <form
                                action="{{ route('admin.cases.destroy',$case) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this investigation?')">

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="rounded-lg bg-red-700 px-4 py-2 text-white hover:bg-red-600">

                                    Delete

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="5"
                        class="py-16 text-center text-slate-500">

                        No investigations found.

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