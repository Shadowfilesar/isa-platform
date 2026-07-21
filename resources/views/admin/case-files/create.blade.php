@extends('layouts.admin')

@section('title','Upload File')

@section('content')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['label' => 'Cases', 'href' => route('admin.cases.index')],
        ['label' => $case->code . ' Files', 'href' => route('admin.case-files.index',$case)],
        ['label' => 'Upload File'],
    ];
@endphp

<div class="p-10 admin-page-stack">
    <x-admin.breadcrumbs :items="$breadcrumbs" />

    <x-admin.action-toolbar
        title="Upload File"
        :subtitle="$case->code . ' / ' . $case->title">
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
            action="{{ route('admin.case-files.store',$case) }}"
            enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-slate-400">Section</label>
                    <input name="section" value="{{ old('section') }}" list="case-file-sections" placeholder="Mission" class="isa-input">

                    <datalist id="case-file-sections">
                        @foreach($sections as $section)
                            <option value="{{ $section }}"></option>
                        @endforeach
                    </datalist>
                </div>

                <div>
                    <label class="block mb-2 text-slate-400">Category</label>
                    <input name="category" value="{{ old('category') }}" list="case-file-categories" placeholder="Evidence" class="isa-input">

                    <datalist id="case-file-categories">
                        @foreach($categories as $category)
                            <option value="{{ $category }}"></option>
                        @endforeach
                    </datalist>
                </div>
            </div>

            <div>
                <label class="block mb-2 text-slate-400">Title</label>
                <input name="title" value="{{ old('title') }}" placeholder="Mission Brief" class="isa-input">
            </div>

            <div>
                <label class="block mb-2 text-slate-400">Description</label>
                <textarea name="description" rows="4" class="isa-input">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-slate-400">Display Order</label>
                    <input type="number" name="display_order" value="{{ old('display_order',$nextDisplayOrder) }}" class="isa-input">
                </div>

                <div class="grid grid-cols-2 gap-4 items-end">
                    <label class="flex items-center gap-3 text-slate-300">
                        <input type="checkbox" name="locked" value="1" @checked(old('locked'))>
                        Locked
                    </label>

                    <label class="flex items-center gap-3 text-slate-300">
                        <input type="checkbox" name="public" value="1" @checked(old('public'))>
                        Public
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block mb-2 text-slate-400">Unlock Event</label>
                    <input name="unlock_event" value="{{ old('unlock_event') }}" placeholder="mission_completed" class="isa-input">
                </div>

                <div>
                    <label class="block mb-2 text-slate-400">Required Rank</label>
                    <input name="required_rank" value="{{ old('required_rank') }}" placeholder="Detective" class="isa-input">
                </div>

                <div>
                    <label class="block mb-2 text-slate-400">Required Clearance</label>
                    <input name="required_clearance" value="{{ old('required_clearance') }}" placeholder="Level 2" class="isa-input">
                </div>
            </div>

            <div>
                <label class="block mb-2 text-slate-400">File</label>
                <input type="file" name="file" class="isa-input">
            </div>

            <div class="flex justify-end gap-3">
                <x-admin.icon-button
                    :href="route('admin.case-files.index',$case)"
                    label="Cancel"
                    icon="←"
                    variant="neutral" />

                <button type="submit">
                    <x-admin.icon-button
                        label="Upload"
                        icon="↑"
                        variant="accent" />
                </button>
            </div>
        </form>
    </div>
</div>

@endsection