@extends('layouts.admin')

@section('title','Upload File')

@php
    $breadcrumbs = [
        ['route' => 'admin.cases.index', 'label' => 'Cases'],
        ['route' => 'admin.case-files.index', 'params' => $case, 'label' => $case->code.' Files'],
        ['label' => 'Upload File'],
    ];
@endphp

@section('admin-content')

    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-4xl font-bold text-white">

                Upload File

            </h1>

            <p class="text-slate-500 mt-2">

                {{ $case->code }} / {{ $case->title }}

            </p>

        </div>

    </div>

    <form
        method="POST"
        action="{{ route('admin.case-files.store',$case) }}"
        enctype="multipart/form-data"
        class="executive-card p-8 space-y-6">

        @csrf

        <div>

            <label class="block mb-2 text-slate-400">

                Section

            </label>

            <input
                name="section"
                value="{{ old('section') }}"
                list="case-file-sections"
                placeholder="Mission"
                class="isa-input">

            <datalist id="case-file-sections">

                @foreach($sections as $section)

                    <option value="{{ $section }}"></option>

                @endforeach

            </datalist>

        </div>

        <div>

            <label class="block mb-2 text-slate-400">

                Title

            </label>

            <input
                name="title"
                value="{{ old('title') }}"
                placeholder="Mission Brief"
                class="isa-input">

        </div>

        <div>

            <label class="block mb-2 text-slate-400">

                Description

            </label>

            <textarea
                name="description"
                rows="4"
                class="isa-input">{{ old('description') }}</textarea>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>

                <label class="block mb-2 text-slate-400">

                    File Type

                </label>

                <select
                    name="file_type"
                    class="isa-input">

                    @foreach($fileTypes as $fileType)

                        <option
                            value="{{ $fileType }}"
                            @selected(old('file_type') === $fileType)>

                            {{ $fileType }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div>

                <label class="block mb-2 text-slate-400">

                    Display Order

                </label>

                <input
                    type="number"
                    name="display_order"
                    value="{{ old('display_order',$nextDisplayOrder) }}"
                    class="isa-input">

            </div>

        </div>

        <label class="flex items-center gap-3 text-slate-300">

            <input
                type="checkbox"
                name="locked"
                value="1"
                @checked(old('locked'))>

            Locked

        </label>

        <div>

            <label class="block mb-2 text-slate-400">

                File

            </label>

            <input
                type="file"
                name="file"
                class="isa-input">

        </div>

        <button
            type="submit"
            class="isa-button">

            Upload

        </button>

    </form>

@endsection