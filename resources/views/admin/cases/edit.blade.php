@extends('layouts.admin')

@section('title','Edit Case')

@section('content')

<div class="p-10">
    <h1 class="text-4xl text-white mb-8">
        Edit Investigation
    </h1>

    <form
        method="POST"
        action="{{ route('admin.cases.update',$case) }}"
        class="executive-card p-8 space-y-6">
        @csrf
        @method('PUT')

        <input
            name="code"
            value="{{ old('code', $case->code) }}"
            class="w-full rounded border border-slate-700 bg-slate-900 px-5 py-3 text-white">

        <input
            name="title"
            value="{{ old('title', $case->title) }}"
            class="w-full rounded border border-slate-700 bg-slate-900 px-5 py-3 text-white">

        <textarea
            name="description"
            rows="6"
            class="w-full rounded border border-slate-700 bg-slate-900 px-5 py-3 text-white">{{ old('description', $case->description) }}</textarea>

        <select
            name="difficulty"
            class="w-full rounded border border-slate-700 bg-slate-900 px-5 py-3 text-white">
            <option value="Easy" {{ old('difficulty', $case->difficulty) === 'Easy' ? 'selected' : '' }}>Easy</option>
            <option value="Medium" {{ old('difficulty', $case->difficulty) === 'Medium' ? 'selected' : '' }}>Medium</option>
            <option value="Hard" {{ old('difficulty', $case->difficulty) === 'Hard' ? 'selected' : '' }}>Hard</option>
        </select>

        <label class="flex items-center gap-3 text-white">
            <input
                type="checkbox"
                name="published"
                value="1"
                {{ old('published', $case->published) ? 'checked' : '' }}>
            Published
        </label>

        <div class="flex items-center justify-end gap-4">
            <a
                href="{{ route('admin.cases.index') }}"
                class="rounded bg-slate-800 px-8 py-3 text-white">
                Cancel
            </a>

            <button
                class="rounded bg-amber-600 px-8 py-3 text-white">
                Update Case
            </button>
        </div>
    </form>
</div>

@endsection