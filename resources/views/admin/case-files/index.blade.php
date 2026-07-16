@extends('layouts.admin')

@section('title','File Manager V2')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-100">
    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/20 bg-cyan-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-cyan-300">
                    <span class="inline-block h-2 w-2 rounded-full bg-cyan-400"></span>
                    File Manager V2
                </div>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight text-white sm:text-3xl">Investigation Files</h1>
                <p class="mt-2 max-w-3xl text-sm text-slate-400 sm:text-base">
                    {{ $case->code }} / {{ $case->title }}
                </p>
            </div>

            <a href="{{ route('admin.case-files.create', $case) }}"
               class="inline-flex items-center justify-center rounded-xl bg-cyan-500 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">
                Upload File
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-5 py-4 text-sm font-medium text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 shadow-2xl shadow-black/20">
                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Total Files</div>
                <div class="mt-3 text-3xl font-semibold text-white">{{ $stats['totalFiles'] }}</div>
                <div class="mt-2 text-sm text-slate-400">Case archive assets</div>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 shadow-2xl shadow-black/20">
                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Locked Files</div>
                <div class="mt-3 text-3xl font-semibold text-amber-300">{{ $stats['lockedFiles'] }}</div>
                <div class="mt-2 text-sm text-slate-400">Restricted access items</div>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 shadow-2xl shadow-black/20">
                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Unlocked Files</div>
                <div class="mt-3 text-3xl font-semibold text-emerald-300">{{ $stats['unlockedFiles'] }}</div>
                <div class="mt-2 text-sm text-slate-400">Available for access</div>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 shadow-2xl shadow-black/20">
                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Last Updated</div>
                <div class="mt-3 text-lg font-semibold text-white">
                    {{ $stats['lastUpdated']?->format('M d, Y') ?? 'No files yet' }}
                </div>
                <div class="mt-2 text-sm text-slate-400">
                    {{ $stats['totalSections'] }} {{ \Illuminate\Support\Str::plural('section', $stats['totalSections']) }}
                </div>
            </div>
        </div>

        <div class="mb-6 overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
            <form method="GET" action="{{ route('admin.case-files.index', $case) }}" class="flex flex-col gap-4 p-5 lg:flex-row lg:items-center">
                <div class="relative flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="11" cy="11" r="7"></circle>
                        <path stroke-linecap="round" d="m20 20-3.5-3.5"></path>
                    </svg>
                    <input type="search"
                           name="search"
                           value="{{ $search }}"
                           placeholder="Search titles, categories, sections, file names, or MIME types..."
                           class="w-full rounded-xl border border-slate-700 bg-slate-950 py-3 pl-12 pr-4 text-sm text-slate-100 outline-none transition placeholder:text-slate-500 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="inline-flex flex-1 items-center justify-center rounded-xl bg-cyan-500 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400 lg:flex-none">
                        Search
                    </button>

                    @if($search)
                        <a href="{{ route('admin.case-files.index', $case) }}" class="inline-flex flex-1 items-center justify-center rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm font-medium text-slate-200 transition hover:border-slate-600 hover:bg-slate-900 lg:flex-none">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if($files->isEmpty())
            <div class="rounded-3xl border border-dashed border-slate-700 bg-slate-900/70 px-6 py-16 text-center shadow-2xl shadow-black/20">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-cyan-500/20 bg-cyan-500/10 text-cyan-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75A2.25 2.25 0 0 1 6 4.5h4.114c.597 0 1.17.237 1.591.659l.636.636c.422.422.994.659 1.591.659H18A2.25 2.25 0 0 1 20.25 8.7v8.55A2.25 2.25 0 0 1 18 19.5H6a2.25 2.25 0 0 1-2.25-2.25V6.75Z"/>
                    </svg>
                </div>
                <h2 class="mt-5 text-xl font-semibold text-white">{{ $search ? 'No matching files found' : 'No files in this case yet' }}</h2>
                <p class="mx-auto mt-2 max-w-md text-sm text-slate-400">
                    {{ $search ? 'Try a different search term or clear the current search.' : 'Upload the first case asset to start building the investigation archive.' }}
                </p>
                <a href="{{ route('admin.case-files.create', $case) }}" class="mt-6 inline-flex items-center justify-center rounded-xl bg-cyan-500 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">
                    Upload File
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($sectionGroups as $section => $sectionFiles)
                    <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                        <div class="flex flex-col gap-3 border-b border-slate-800 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-white">{{ $section ?: 'Unassigned Section' }}</h2>
                                <p class="mt-1 text-sm text-slate-400">
                                    {{ $sectionFiles->count() }} {{ \Illuminate\Support\Str::plural('file', $sectionFiles->count()) }}
                                </p>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-[1100px] w-full text-left">
                                <thead class="border-b border-slate-800 bg-slate-950/50">
                                    <tr class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                        <th class="px-6 py-4">File</th>
                                        <th class="px-6 py-4">Category</th>
                                        <th class="px-6 py-4">Details</th>
                                        <th class="px-6 py-4">Security</th>
                                        <th class="px-6 py-4">Order</th>
                                        <th class="px-6 py-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800">
                                    @foreach($sectionFiles as $file)
                                        <tr class="bg-slate-900/40 transition hover:bg-slate-800/50">
                                            <td class="px-6 py-5">
                                                <div class="flex min-w-[260px] items-start gap-4">
                                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-cyan-500/20 bg-cyan-500/10 text-cyan-300">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 2.25v4.5a.75.75 0 0 0 .75.75h4.5m-5.25-5.25H6.75A2.25 2.25 0 0 0 4.5 4.5v15A2.25 2.25 0 0 0 6.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25V7.5l-5.25-5.25Z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <div class="font-semibold text-white">{{ $file->title }}</div>
                                                        <div class="mt-1 truncate text-sm text-slate-400">{{ $file->original_name }}</div>
                                                        @if($file->description)
                                                            <div class="mt-2 line-clamp-2 max-w-md text-sm text-slate-500">{{ $file->description }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="px-6 py-5">
                                                <span class="inline-flex rounded-full border border-cyan-500/20 bg-cyan-500/10 px-3 py-1 text-xs font-semibold capitalize text-cyan-300">
                                                    {{ $file->category }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-5">
                                                <div class="space-y-1 text-sm">
                                                    <div class="font-medium text-slate-200">{{ strtoupper($file->extension ?: 'FILE') }}</div>
                                                    <div class="text-slate-400">{{ $file->mime_type ?: 'Unknown MIME type' }}</div>
                                                    <div class="text-slate-500">{{ number_format(($file->file_size ?? 0) / 1024, 2) }} KB</div>
                                                </div>
                                            </td>

                                            <td class="px-6 py-5">
                                                <div class="flex min-w-[160px] flex-col items-start gap-2">
                                                    @if($file->locked)
                                                        <span class="inline-flex rounded-full border border-amber-500/20 bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-300">Locked</span>
                                                    @else
                                                        <span class="inline-flex rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-300">Unlocked</span>
                                                    @endif

                                                    @if($file->public)
                                                        <span class="text-xs font-medium text-cyan-300">Public</span>
                                                    @else
                                                        <span class="text-xs font-medium text-slate-500">Private</span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="px-6 py-5 text-sm font-medium text-slate-300">
                                                {{ $file->display_order }}
                                            </td>

                                            <td class="px-6 py-5">
                                                <div class="flex justify-end gap-2">
                                                    @if($file->file_path)
                                                        <a href="{{ asset($file->file_path) }}"
                                                           target="_blank"
                                                           rel="noopener noreferrer"
                                                           class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-700 bg-slate-950 text-slate-300 transition hover:border-cyan-500/50 hover:bg-cyan-500/10 hover:text-cyan-300"
                                                           title="Preview File">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"/>
                                                                <circle cx="12" cy="12" r="2.25"/>
                                                            </svg>
                                                        </a>
                                                    @endif

                                                    <form method="POST" action="{{ route('admin.case-files.toggle-lock', [$case, $file]) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border {{ $file->locked ? 'border-amber-500/30 bg-amber-500/10 text-amber-300 hover:bg-amber-500/20' : 'border-slate-700 bg-slate-950 text-slate-300 hover:border-amber-500/50 hover:bg-amber-500/10 hover:text-amber-300' }} transition"
                                                                title="{{ $file->locked ? 'Unlock File' : 'Lock File' }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                                @if($file->locked)
                                                                    <rect x="5" y="10" width="14" height="10" rx="2"/>
                                                                    <path stroke-linecap="round" d="M8 10V7a4 4 0 0 1 8 0v3"/>
                                                                @else
                                                                    <rect x="5" y="10" width="14" height="10" rx="2"/>
                                                                    <path stroke-linecap="round" d="M8 10V7a4 4 0 0 1 7.5-2.5"/>
                                                                @endif
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    <a href="{{ route('admin.case-files.edit', [$case, $file]) }}"
                                                       class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-700 bg-slate-950 text-slate-300 transition hover:border-cyan-500/50 hover:bg-cyan-500/10 hover:text-cyan-300"
                                                       title="Edit File">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 3.487 1.65-1.65a2.121 2.121 0 1 1 3 3l-1.65 1.65m-3-3 3 3m-12.75 12.75 3.75-.75L19.5 7.837l-3-3L7.862 13.5l-.75 3.75Z"/>
                                                        </svg>
                                                    </a>

                                                    <form method="POST" action="{{ route('admin.case-files.destroy', [$case, $file]) }}" onsubmit="return confirm('Delete this file permanently?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-700 bg-slate-950 text-slate-300 transition hover:border-rose-500/50 hover:bg-rose-500/10 hover:text-rose-300"
                                                                title="Delete File">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9 14.394 18m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21.75H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0V4.875c0-1.242-.987-2.25-2.25-2.25h-3c-1.263 0-2.25 1.008-2.25 2.25v.918m7.5 0a45.668 45.668 0 0 0-7.5 0"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection