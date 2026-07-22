@extends('layouts.admin')

@section('title','Edit Case')

@section('content')
<div class="p-10">
    <div class="mb-8">
        <a
            href="{{ route('admin.cases.index') }}"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-700 bg-slate-900 px-5 py-3 text-white transition hover:border-amber-500">
            Back to Cases
        </a>

        <div class="mt-5 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-white">Dashboard</a>
            <span class="mx-2">/</span>
            <a href="{{ route('admin.cases.index') }}" class="hover:text-white">Cases</a>
            <span class="mx-2">/</span>
            <span class="text-amber-400">Edit Case</span>
        </div>
    </div>

    <div class="mb-10">
        <h1 class="text-4xl font-bold text-white">
            Edit Investigation Case
        </h1>

        <p class="mt-2 text-slate-500">
            Update case information for
            <span class="text-white">{{ $case->code }}</span>.
        </p>
    </div>

    @if($errors->any())
        <div class="mb-8 rounded-lg border border-red-700 bg-red-900/40 px-5 py-4 text-red-300">
            <div class="mb-3 text-sm font-semibold uppercase tracking-widest">
                Validation Errors
            </div>
            <ul class="space-y-1 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('admin.cases.update', $case) }}"
        class="executive-card p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-8 xl:grid-cols-3">
            <div class="xl:col-span-2">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="code" class="mb-2 block text-sm font-semibold text-slate-300">
                            Case Code
                        </label>
                        <input
                            id="code"
                            name="code"
                            type="text"
                            value="{{ old('code', $case->code) }}"
                            placeholder="CASE-001"
                            class="isa-input">
                    </div>

                    <div>
                        <label for="difficulty" class="mb-2 block text-sm font-semibold text-slate-300">
                            Difficulty
                        </label>
                        <select
                            id="difficulty"
                            name="difficulty"
                            class="isa-input">
                            <option value="">Select Difficulty</option>
                            <option value="Easy" {{ old('difficulty', $case->difficulty) === 'Easy' ? 'selected' : '' }}>Easy</option>
                            <option value="Medium" {{ old('difficulty', $case->difficulty) === 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="Hard" {{ old('difficulty', $case->difficulty) === 'Hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="title" class="mb-2 block text-sm font-semibold text-slate-300">
                            Title
                        </label>
                        <input
                            id="title"
                            name="title"
                            type="text"
                            value="{{ old('title', $case->title) }}"
                            placeholder="Operation Silent Echo"
                            class="isa-input">
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="mb-2 block text-sm font-semibold text-slate-300">
                            Description
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="8"
                            placeholder="Enter case background, objective, and summary..."
                            class="isa-input">{{ old('description', $case->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-800 bg-slate-950/50 p-6">
                    <h2 class="text-lg font-bold text-white">
                        Publication
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Control whether this case is currently visible to investigators.
                    </p>

                    <div class="mt-6">
                        <input type="hidden" name="published" value="0">

                        <label class="flex items-start gap-4 rounded-lg border border-slate-700 bg-slate-900 p-5 transition hover:border-amber-500">
                            <input
                                type="checkbox"
                                name="published"
                                value="1"
                                {{ old('published', $case->published) ? 'checked' : '' }}
                                class="mt-1 h-4 w-4 rounded border-slate-600 bg-slate-800 text-amber-500 focus:ring-amber-500/30">

                            <div>
                                <div class="font-semibold text-white">
                                    Published Case
                                </div>
                                <div class="mt-1 text-sm text-slate-500">
                                    Uncheck to keep this case hidden from active release.
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-slate-950/50 p-6">
                    <h2 class="text-lg font-bold text-white">
                        Case Snapshot
                    </h2>

                    <div class="mt-4 space-y-4 text-sm">
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-slate-500">Current Code</span>
                            <span class="font-semibold text-white">{{ $case->code }}</span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-slate-500">Current Difficulty</span>
                            <span class="font-semibold text-white">{{ $case->difficulty }}</span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-slate-500">Status</span>
                            <span class="font-semibold {{ $case->published ? 'text-green-400' : 'text-amber-400' }}">
                                {{ $case->published ? 'Published' : 'Draft' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-slate-500">Created</span>
                            <span class="font-semibold text-white">
                                {{ optional($case->created_at)->format('Y-m-d H:i') ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>
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
                Save Case
            </button>
        </div>
    </form>
</div>
@endsection