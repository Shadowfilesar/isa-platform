@extends('layouts.admin')

@section('title','Create Investigation')

@section('content')

<div class="p-10">

    <div class="mb-8">

        <a
            href="{{ route('admin.cases.index') }}"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-700 bg-slate-900 px-5 py-3 text-white transition hover:border-amber-500">

            ← Back to Cases

        </a>

        <div class="mt-5 text-sm text-slate-500">

            <a
                href="{{ route('admin.dashboard') }}"
                class="hover:text-white">

                Dashboard

            </a>

            <span class="mx-2">/</span>

            <a
                href="{{ route('admin.cases.index') }}"
                class="hover:text-white">

                Cases

            </a>

            <span class="mx-2">/</span>

            <span class="text-amber-400">

                Create Investigation

            </span>

        </div>

    </div>

    <div class="mb-10">

        <h1 class="text-4xl font-bold text-white">

            Create Investigation

        </h1>

        <p class="mt-3 text-slate-500">

            Create a new investigation available inside ISA.

        </p>

    </div>

    <form
        method="POST"
        action="{{ route('admin.cases.store') }}"
        class="executive-card p-8 space-y-6">

        @csrf

        <div>

            <label class="mb-2 block text-sm text-slate-400">

                Case Code

            </label>

            <input
                name="code"
                value="{{ old('code') }}"
                placeholder="CS-001"
                class="isa-input">

        </div>

        <div>

            <label class="mb-2 block text-sm text-slate-400">

                Case Title

            </label>

            <input
                name="title"
                value="{{ old('title') }}"
                placeholder="Case Title"
                class="isa-input">

        </div>

        <div>

            <label class="mb-2 block text-sm text-slate-400">

                Description

            </label>

            <textarea
                name="description"
                rows="8"
                class="isa-input"
                placeholder="Case Description">{{ old('description') }}</textarea>

        </div>

        <div class="grid gap-6 md:grid-cols-2">

            <div>

                <label class="mb-2 block text-sm text-slate-400">

                    Difficulty

                </label>

                <select
                    name="difficulty"
                    class="isa-input">

                    <option value="Easy">Easy</option>

                    <option value="Medium">Medium</option>

                    <option value="Hard">Hard</option>

                </select>

            </div>

            <div>

                <label class="mb-2 block text-sm text-slate-400">

                    Publication

                </label>

                <label class="flex items-center gap-3 rounded-lg border border-slate-700 bg-slate-900 p-4">

                    <input
                        type="checkbox"
                        name="published"
                        value="1">

                    <span class="text-white">

                        Publish immediately

                    </span>

                </label>

            </div>

        </div>
                <div class="border-t border-slate-800 pt-8">

            <h2 class="mb-6 text-xl font-bold text-white">

                Quick Actions

            </h2>

            <div class="grid gap-4 md:grid-cols-3">

                <a
                    href="{{ route('admin.cases.index') }}"
                    class="rounded-lg bg-slate-800 px-6 py-4 text-center font-semibold text-white transition hover:bg-slate-700">

                    📋 All Cases

                </a>

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="rounded-lg bg-slate-800 px-6 py-4 text-center font-semibold text-white transition hover:bg-slate-700">

                    🏠 Dashboard

                </a>

                <a
                    href="{{ route('admin.mission-codes.index') }}"
                    class="rounded-lg bg-slate-800 px-6 py-4 text-center font-semibold text-white transition hover:bg-slate-700">

                    🔑 Mission Codes

                </a>

            </div>

        </div>

        <div class="mt-10 flex items-center justify-end gap-4 border-t border-slate-800 pt-8">

            <a
                href="{{ route('admin.cases.index') }}"
                class="rounded-lg border border-slate-700 bg-slate-900 px-8 py-3 font-semibold text-white transition hover:border-slate-500">

                Cancel

            </a>

            <button
                type="submit"
                class="rounded-lg bg-amber-600 px-8 py-3 font-semibold text-white transition hover:bg-amber-500">

                Create Investigation

            </button>

        </div>

    </form>

</div>

@endsection