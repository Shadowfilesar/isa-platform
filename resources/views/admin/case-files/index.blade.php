@extends('layouts.admin')

@section('title','Case Files')

@php
    $breadcrumbs = [
        ['route' => 'admin.cases.index', 'label' => 'Cases'],
        ['label' => $case->code.' Files'],
    ];
@endphp

@section('admin-content')

    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-4xl font-bold text-white">

                {{ $case->title }}

            </h1>

            <p class="text-slate-500 mt-2">

                {{ $case->code }} / File Manager

            </p>

        </div>

        <div class="flex gap-3">

            
                href="{{ route('admin.case-files.create',$case) }}"
                class="rounded bg-amber-600 px-6 py-3 text-white">

                + Upload File

            </a>

        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        <div class="executive-card p-6">

            <h2 class="text-xl font-bold text-white mb-4">

                Sections

            </h2>

            <div class="flex flex-wrap gap-2">

                @forelse($sections as $section)

                    <span class="rounded bg-slate-800 px-3 py-2 text-sm text-slate-200">

                        {{ $section }}

                    </span>

                @empty

                    <span class="text-slate-500">

                        No sections yet.

                    </span>

                @endforelse

            </div>

        </div>

        <div class="executive-card p-6">

            <h2 class="text-xl font-bold text-white mb-4">

                File Types

            </h2>

            <div class="flex flex-wrap gap-2">

                @foreach($fileTypes as $fileType)

                    <span class="rounded bg-slate-800 px-3 py-2 text-sm text-slate-200">

                        {{ $fileType }}

                    </span>

                @endforeach

            </div>

        </div>

    </div>

    <div class="executive-card overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-900">

                <tr>

                    <th class="text-left p-4">Section</th>
                    <th class="text-left p-4">Title</th>
                    <th class="text-left p-4">Type</th>
                    <th class="text-left p-4">Order</th>
                    <th class="text-left p-4">Locked</th>
                    <th class="text-right p-4">Actions</th>

                </tr>

            </thead>

            <tbody>

            @forelse($files as $file)

                <tr class="border-t border-slate-800">

                    <td class="p-4">

                        {{ $file->section }}

                    </td>

                    <td class="p-4">

                        <div class="font-semibold text-white">

                            {{ $file->title }}

                        </div>

                        @if($file->description)

                            <div class="text-sm text-slate-500 mt-1">

                                {{ $file->description }}

                            </div>

                        @endif

                    </td>

                    <td class="p-4">

                        {{ $file->file_type }}

                    </td>

                    <td class="p-4">

                        <form
                            method="POST"
                            action="{{ route('admin.case-files.reorder',$case) }}"
                            class="flex items-center gap-2">

                            @csrf

                            <input
                                type="hidden"
                                name="files[0][id]"
                                value="{{ $file->id }}">

                            <input
                                type="number"
                                name="files[0][display_order]"
                                value="{{ $file->display_order }}"
                                class="isa-input max-w-24">

                            <button
                                type="submit"
                                class="rounded bg-slate-700 px-3 py-2 text-white">

                                Save

                            </button>

                        </form>

                    </td>

                    <td class="p-4">

                        @if($file->locked)

                            <span class="text-red-400">

                                Locked

                            </span>

                        @else

                            <span class="text-green-400">

                                Open

                            </span>

                        @endif

                    </td>

                    <td class="p-4">

                        <div class="flex justify-end gap-3">

                            
                                href="{{ asset($file->file_path) }}"
                                target="_blank"
                                class="rounded bg-slate-800 px-4 py-2 text-white">

                                View

                            </a>

                            <form
                                action="{{ route('admin.case-files.toggle-lock',[$case,$file]) }}"
                                method="POST">

                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="rounded bg-slate-700 px-4 py-2 text-white">

                                    {{ $file->locked ? 'Unlock' : 'Lock' }}

                                </button>

                            </form>

                            
                                href="{{ route('admin.case-files.edit',[$case,$file]) }}"
                                class="rounded bg-amber-600 px-4 py-2 text-white">

                                Edit

                            </a>

                            <form
                                action="{{ route('admin.case-files.destroy',[$case,$file]) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this file?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
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

                        No files uploaded yet.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

@endsection