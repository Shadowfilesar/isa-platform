@extends('layouts.admin')

@section('title','Case Files')

@section('content')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['label' => 'Cases', 'href' => route('admin.cases.index')],
        ['label' => $case->code . ' Files'],
    ];
@endphp

<div class="p-10 admin-page-stack">
    <x-admin.breadcrumbs :items="$breadcrumbs" />

    <x-admin.action-toolbar
        :title="$case->title"
        :subtitle="$case->code . ' / File Manager'">
        <x-slot:actions>
            <x-admin.icon-button
                :href="route('admin.cases.index')"
                label="Back"
                icon="←"
                variant="neutral" />

            <x-admin.icon-button
                :href="route('admin.case-files.create',$case)"
                label="Upload File"
                icon="+"
                variant="accent" />
        </x-slot:actions>
    </x-admin.action-toolbar>

    <x-admin.search-bar
        :action="route('admin.case-files.index',$case)"
        placeholder="Search files by title, category or metadata" />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-admin.filter-chip-group
            title="Sections"
            :items="$sections"
            empty="No sections yet." />

        <x-admin.filter-chip-group
            title="Categories"
            :items="$categories"
            empty="No categories yet." />
    </div>

    @if($files->isEmpty())
        <x-admin.empty-state
            title="No files uploaded yet"
            message="This case does not contain any file records yet. Upload the first file to begin organizing mission content.">
            <x-admin.icon-button
                :href="route('admin.case-files.create',$case)"
                label="Upload File"
                icon="+"
                variant="accent" />
        </x-admin.empty-state>
    @else
        <div class="admin-file-grid">
            @foreach($files as $file)
                <x-admin.file-card :case="$case" :file="$file" />
            @endforeach
        </div>
    @endif
</div>

@endsection