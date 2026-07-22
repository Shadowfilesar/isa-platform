<?php
// resources/views/admin/case-files/edit.blade.php
?>
@extends('layouts.admin')

@section('title', 'Edit Case File')

@section('admin-content')
<div class="space-y-6">
    <div class="executive-card p-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-white">Edit Case File</h1>
            <p class="mt-2 text-slate-400">Update file details for <span class="text-amber-400">{{ $case->title }}</span>.</p>
        </div>

        <form action="{{ route('admin.case-files.update', [$case, $file]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="mb-2 block text-sm font-medium text-slate-300">Title</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $file->title) }}"
                    required
                    class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white focus:border-amber-500 focus:outline-none">
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="category" class="mb-2 block text-sm font-medium text-slate-300">Category</label>
                    <select
                        name="category"
                        id="category"
                        required
                        class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white focus:border-amber-500 focus:outline-none">
                        <option value="">Select category</option>
                        @foreach(($categories ?? []) as $category)
                            <option value="{{ $category }}" {{ old('category', $file->category) === $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="display_order" class="mb-2 block text-sm font-medium text-slate-300">Display Order</label>
                    <input
                        type="number"
                        name="display_order"
                        id="display_order"
                        value="{{ old('display_order', $file->display_order) }}"
                        required
                        class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white focus:border-amber-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label for="section" class="mb-2 block text-sm font-medium text-slate-300">Section</label>
                <input
                    type="text"
                    name="section"
                    id="section"
                    list="section-suggestions"
                    value="{{ old('section', $file->section) }}"
                    required
                    placeholder="Type or choose a section"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white focus:border-amber-500 focus:outline-none">
                <datalist id="section-suggestions">
                    @foreach(($sections ?? []) as $section)
                        <option value="{{ $section }}">
                    @endforeach
                </datalist>
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-medium text-slate-300">Description</label>
                <textarea
                    name="description"
                    id="description"
                    rows="5"
                    required
                    class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white focus:border-amber-500 focus:outline-none">{{ old('description', $file->description) }}</textarea>
            </div>

            <div>
                <label for="file" class="mb-2 block text-sm font-medium text-slate-300">Upload File</label>
                <input
                    type="file"
                    name="file"
                    id="file"
                    class="block w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-slate-300 file:mr-4 file:rounded-md file:border-0 file:bg-amber-600 file:px-4 file:py-2 file:text-white hover:file:bg-amber-500">
                @if(!empty($file->file_path))
                    <p class="mt-2 text-sm text-slate-500">Current file: {{ basename($file->file_path) }}</p>
                @endif
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-slate-800 pt-6">
                <a href="{{ route('admin.case-files.index', $case) }}" class="rounded-lg border border-slate-700 px-5 py-3 text-white hover:bg-slate-800">
                    Cancel
                </a>
                <button type="submit" class="rounded-lg bg-amber-600 px-5 py-3 font-semibold text-white hover:bg-amber-500">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection