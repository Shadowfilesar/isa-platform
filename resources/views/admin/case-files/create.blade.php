@extends('layouts.admin')

@section('title','Upload File')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-100">
    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/20 bg-cyan-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-cyan-300">
                    <span class="inline-block h-2 w-2 rounded-full bg-cyan-400"></span>
                    File Manager V2
                </div>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight text-white sm:text-3xl">Create File</h1>
                <p class="mt-2 max-w-3xl text-sm text-slate-400 sm:text-base">
                    Upload a new case asset with security controls, classification, and professional file management options.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.case-files.index', $case) }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-800 bg-slate-900/80 px-4 py-2.5 text-sm font-medium text-slate-200 shadow-lg shadow-black/20 transition hover:border-slate-700 hover:bg-slate-800">
                    Back to Files
                </a>
            </div>
        </div>

        <div class="mb-6 grid gap-4 lg:grid-cols-3">
            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 shadow-2xl shadow-black/20">
                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Case Code</div>
                <div class="mt-2 text-lg font-semibold text-white">{{ $case->code }}</div>
            </div>
            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 shadow-2xl shadow-black/20 lg:col-span-2">
                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Case Title</div>
                <div class="mt-2 text-lg font-semibold text-white">{{ $case->title }}</div>
            </div>
        </div>

        <form method="POST"
              action="{{ route('admin.case-files.store', $case) }}"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf

            <div class="grid gap-6 xl:grid-cols-3">
                <div class="space-y-6 xl:col-span-2">
                    <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                        <div class="border-b border-slate-800 px-6 py-5">
                            <h2 class="text-lg font-semibold text-white">Upload</h2>
                            <p class="mt-1 text-sm text-slate-400">
                                Select the evidence or document file you want to attach to this investigation.
                            </p>
                        </div>

                        <div class="p-6">
                            <label for="file"
                                   class="group flex cursor-pointer flex-col items-center justify-center rounded-2xl border border-dashed border-slate-700 bg-slate-950/70 px-6 py-12 text-center transition hover:border-cyan-500/40 hover:bg-cyan-500/5">
                                <div class="flex h-16 w-16 items-center justify-center rounded-2xl border border-cyan-500/20 bg-cyan-500/10 text-cyan-300 transition group-hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0-4 4m4-4 4 4M4 16.5v1.25A2.25 2.25 0 0 0 6.25 20h11.5A2.25 2.25 0 0 0 20 17.75V16.5"/>
                                    </svg>
                                </div>
                                <div class="mt-5 text-base font-semibold text-white">Choose file to upload</div>
                                <div class="mt-2 text-sm text-slate-400">
                                    Click to browse and attach the original file.
                                </div>
                                <input id="file" name="file" type="file" class="sr-only" required>
                            </label>

                            @error('file')
                                <div class="mt-3 rounded-xl border border-rose-500/20 bg-rose-500/10 px-4 py-3 text-sm text-rose-300">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                        <div class="border-b border-slate-800 px-6 py-5">
                            <h2 class="text-lg font-semibold text-white">Classification</h2>
                            <p class="mt-1 text-sm text-slate-400">
                                Assign type, section, operational order, and access requirements.
                            </p>
                        </div>

                        <div class="grid gap-6 p-6 md:grid-cols-2">
                            <div>
                                <label for="category" class="mb-2 block text-sm font-medium text-slate-200">Category</label>
                                <select id="category"
                                        name="category"
                                        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" @selected(old('category') === $category)>{{ ucfirst($category) }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="section" class="mb-2 block text-sm font-medium text-slate-200">Section</label>
                                <input id="section"
                                       name="section"
                                       type="text"
                                       value="{{ old('section') }}"
                                       list="case-file-sections"
                                       placeholder="Mission Files"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                <datalist id="case-file-sections">
                                    @foreach($sections as $section)
                                        <option value="{{ $section }}"></option>
                                    @endforeach
                                </datalist>
                                @error('section')
                                    <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="title" class="mb-2 block text-sm font-medium text-slate-200">Title</label>
                                <input id="title"
                                       name="title"
                                       type="text"
                                       value="{{ old('title') }}"
                                       placeholder="Mission Brief"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                @error('title')
                                    <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="mb-2 block text-sm font-medium text-slate-200">Description</label>
                                <textarea id="description"
                                          name="description"
                                          rows="6"
                                          placeholder="Add file context, notes, or investigative details..."
                                          class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="display_order" class="mb-2 block text-sm font-medium text-slate-200">Display Order</label>
                                <input id="display_order"
                                       name="display_order"
                                       type="number"
                                       min="0"
                                       value="{{ old('display_order', $nextDisplayOrder) }}"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                @error('display_order')
                                    <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="required_rank" class="mb-2 block text-sm font-medium text-slate-200">Required Rank</label>
                                <input id="required_rank"
                                       name="required_rank"
                                       type="text"
                                       value="{{ old('required_rank') }}"
                                       placeholder="Detective, Captain, Commander..."
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                @error('required_rank')
                                    <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="required_clearance" class="mb-2 block text-sm font-medium text-slate-200">Required Clearance</label>
                                <input id="required_clearance"
                                       name="required_clearance"
                                       type="text"
                                       value="{{ old('required_clearance') }}"
                                       placeholder="Level 1, Internal, Restricted..."
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                @error('required_clearance')
                                    <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                        <div class="border-b border-slate-800 px-6 py-5">
                            <h2 class="text-lg font-semibold text-white">Security Controls</h2>
                            <p class="mt-1 text-sm text-slate-400">
                                Define lock state, public access, and release event.
                            </p>
                        </div>

                        <div class="space-y-5 p-6">
                            <label class="flex items-start gap-4 rounded-2xl border border-slate-800 bg-slate-950/70 p-4 transition hover:border-slate-700">
                                <input type="checkbox"
                                       name="locked"
                                       value="1"
                                       @checked(old('locked'))
                                       class="mt-1 h-4 w-4 rounded border-slate-600 bg-slate-900 text-cyan-500 focus:ring-cyan-500/30">
                                <div>
                                    <div class="text-sm font-semibold text-white">Locked</div>
                                    <div class="mt-1 text-sm text-slate-400">Require unlock conditions before this file becomes accessible.</div>
                                </div>
                            </label>

                            <label class="flex items-start gap-4 rounded-2xl border border-slate-800 bg-slate-950/70 p-4 transition hover:border-slate-700">
                                <input type="checkbox"
                                       name="public"
                                       value="1"
                                       @checked(old('public'))
                                       class="mt-1 h-4 w-4 rounded border-slate-600 bg-slate-900 text-cyan-500 focus:ring-cyan-500/30">
                                <div>
                                    <div class="text-sm font-semibold text-white">Public</div>
                                    <div class="mt-1 text-sm text-slate-400">Allow wider visibility across authorized investigation interfaces.</div>
                                </div>
                            </label>

                            <div>
                                <label for="unlock_event" class="mb-2 block text-sm font-medium text-slate-200">Unlock Event</label>
                                <input id="unlock_event"
                                       name="unlock_event"
                                       type="text"
                                       value="{{ old('unlock_event') }}"
                                       placeholder="Mission completed, interrogation finished..."
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                @error('unlock_event')
                                    <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-3xl border border-slate-800 bg-gradient-to-br from-cyan-500/10 via-slate-900 to-slate-900 shadow-2xl shadow-black/20">
                        <div class="px-6 py-5">
                            <h2 class="text-lg font-semibold text-white">Submission</h2>
                            <p class="mt-1 text-sm text-slate-300">
                                Review your configuration and save this file into the case archive.
                            </p>
                        </div>

                        <div class="space-y-3 px-6 pb-6">
                            <button type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-xl bg-cyan-500 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">
                                Save File
                            </button>

                            <a href="{{ route('admin.case-files.index', $case) }}"
                               class="inline-flex w-full items-center justify-center rounded-xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm font-medium text-slate-200 transition hover:border-slate-600 hover:bg-slate-900">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection