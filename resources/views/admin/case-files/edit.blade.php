@extends('layouts.admin')

@section('title','Edit File')

@section('content')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['label' => 'Cases', 'href' => route('admin.cases.index')],
        ['label' => $case->code . ' Files', 'href' => route('admin.case-files.index',$case)],
        ['label' => 'Edit File'],
    ];
@endphp

<div class="p-10 admin-page-stack">
    <x-admin.breadcrumbs :items="$breadcrumbs" />

    <x-admin.action-toolbar
        title="Edit File"
        :subtitle="$case->code . ' / ' . $file->title">
        <x-slot:actions>
            <x-admin.icon-button
                :href="route('admin.case-files.index',$case)"
                label="Back"
                icon="←"
                variant="neutral" />
        </x-slot:actions>
    </x-admin.action-toolbar>

    @if($errors->any())
        <x-admin.empty-state
            title="Please correct the form"
            :message="$errors->first()" />
    @endif

    <div class="executive-card p-8">
        <form
            method="POST"
            action="{{ route('admin.case-files.update',[$case,$file]) }}"
            enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-slate-400">Section</label>
                    <input name="section" value="{{ old('section',$file->section) }}" list="case-file-sections" class="isa-input">

                    <datalist id="case-file-sections">
                        @foreach($sections as $section)
                            <option value="{{ $section }}"></option>
                        @endforeach
                    </datalist>
                </div>

                <div>
                    <label class="block mb-2 text-slate-400">Category</label>
                    <input name="category" value="{{ old('category',$file->category) }}" list="case-file-categories" class="isa-input">

                    <datalist id="case-file-categories">
                        @foreach($categories as $category)
                            <option value="{{ $category }}"></option>
                        @endforeach
                    </datalist>
                </div>
            </div>

            <div>
                <label class="block mb-2 text-slate-400">Title</label>
                <input name="title" value="{{ old('title',$file->title) }}" class="isa-input">
            </div>

            <div>
                <label class="block mb-2 text-slate-400">Description</label>
                <textarea name="description" rows="4" class="isa-input">{{ old('description',$file->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-slate-400">Display Order</label>
                    <input type="number" name="display_order" value="{{ old('display_order',$file->display_order) }}" class="isa-input">
                </div>

                <div class="grid grid-cols-2 gap-4 items-end">
                    <label class="flex items-center gap-3 text-slate-300">
                        <input type="checkbox" name="locked" value="1" @checked(old('locked',$file->locked))>
                        Locked
                    </label>

                    <label class="flex items-center gap-3 text-slate-300">
                        <input type="checkbox" name="public" value="1" @checked(old('public',$file->public))>
                        Public
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block mb-2 text-slate-400">Unlock Event</label>
                    <input name="unlock_event" value="{{ old('unlock_event',$file->unlock_event) }}" class="isa-input">
                </div>

                <div>
                    <label class="block mb-2 text-slate-400">Required Rank</label>
                    <input name="required_rank" value="{{ old('required_rank',$file->required_rank) }}" class="isa-input">
                </div>

                <div>
                    <label class="block mb-2 text-slate-400">Required Clearance</label>
                    <input name="required_clearance" value="{{ old('required_clearance',$file->required_clearance) }}" class="isa-input">
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="rounded-2xl border border-slate-800 bg-slate-950/50 p-5">
                    <div class="text-sm font-semibold text-white mb-3">Current File</div>

                    <div class="space-y-3">
                        <a
                            href="{{ route('admin.case-files.show',[$case,$file]) }}"
                            class="text-amber-400">
                            {{ $file->original_name ?: $file->file_name ?: $file->file_path }}
                        </a>

                        <x-admin.meta-list :items="[
                            ['label' => 'MIME', 'value' => $file->mime_type ?: '-'],
                            ['label' => 'Size', 'value' => $file->file_size ? number_format($file->file_size) . ' bytes' : '-'],
                            ['label' => 'Extension', 'value' => $file->extension ?: '-'],
                            ['label' => 'Downloads', 'value' => $file->download_count ?? 0],
                            ['label' => 'Previews', 'value' => $file->preview_count ?? 0],
                            ['label' => 'Version', 'value' => $file->version ?? 1],
                            ['label' => 'SHA256', 'value' => $file->sha256],
                        ]" />

                        <div class="flex gap-3">
                            <x-admin.icon-button
                                :href="route('admin.case-files.show',[$case,$file])"
                                label="Preview"
                                icon="◫"
                                variant="neutral" />

                            <x-admin.icon-button
                                :href="route('admin.case-files.show',[$case,$file])"
                                label="Download"
                                icon="↓"
                                variant="info" />
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-slate-400">Replace File</label>
                    <input type="file" name="file" class="isa-input">
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <x-admin.icon-button
                    :href="route('admin.case-files.index',$case)"
                    label="Cancel"
                    icon="←"
                    variant="neutral" />

                <button type="submit">
                    <x-admin.icon-button
                        label="Save Changes"
                        icon="✓"
                        variant="accent" />
                </button>
            </div>
        </form>
    </div>
</div>

@endsection