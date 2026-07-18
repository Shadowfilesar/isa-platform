@extends('layouts.app')


@section('title', $case->title)
@section('page-title', $case->title)
@section('page-description', 'Investigation Workspace')
@section('breadcrumb', $case->title)


@section('content')
@php
    $navSections = ['Overview', 'Evidence', 'Witnesses', 'Suspects', 'Timeline', 'Notes', 'Documents', 'Board'];


    $detailSections = ['Witnesses', 'Suspects', 'Timeline', 'Notes', 'Documents'];


    $sectionMeta = [
        'Witnesses' => [
            'statsLabel' => 'Witness Records',
            'lockedLabel' => 'Locked Witnesses',
            'availableLabel' => 'Available Witnesses',
            'workspaceTitle' => 'Witnesses Workspace',
            'metaTitle' => 'Witness File',
            'lockedText' => 'Witness statement restricted',
            'buttonText' => 'Open Statement',
            'emptyTitle' => 'No Witness Files',
            'emptyText' => 'This investigation does not contain any witness records in the current workspace yet.',
        ],
        'Suspects' => [
            'statsLabel' => 'Suspect Dossiers',
            'lockedLabel' => 'Locked Dossiers',
            'availableLabel' => 'Available Dossiers',
            'workspaceTitle' => 'Suspects Workspace',
            'metaTitle' => 'Suspect Name',
            'lockedText' => 'Suspect dossier restricted',
            'buttonText' => 'Open Dossier',
            'emptyTitle' => 'No Suspect Files',
            'emptyText' => 'This investigation does not contain any suspect records in the current workspace yet.',
        ],
        'Timeline' => [
            'statsLabel' => 'Timeline Entries',
            'lockedLabel' => 'Locked Entries',
            'availableLabel' => 'Available Entries',
            'workspaceTitle' => 'Timeline Workspace',
            'metaTitle' => 'Timeline Entry',
            'lockedText' => 'Timeline entry restricted',
            'buttonText' => 'Open File',
            'emptyTitle' => 'No Timeline Files',
            'emptyText' => 'This investigation does not contain any timeline records in the current workspace yet.',
        ],
        'Notes' => [
            'statsLabel' => 'Case Notes',
            'lockedLabel' => 'Locked Notes',
            'availableLabel' => 'Available Notes',
            'workspaceTitle' => 'Notes Workspace',
            'metaTitle' => 'Note Title',
            'lockedText' => 'Case note restricted',
            'buttonText' => 'Open File',
            'emptyTitle' => 'No Note Files',
            'emptyText' => 'This investigation does not contain any note records in the current workspace yet.',
        ],
        'Documents' => [
            'statsLabel' => 'Case Documents',
            'lockedLabel' => 'Locked Documents',
            'availableLabel' => 'Available Documents',
            'workspaceTitle' => 'Documents Workspace',
            'metaTitle' => 'Document Title',
            'lockedText' => 'Document access restricted',
            'buttonText' => 'Open File',
            'emptyTitle' => 'No Document Files',
            'emptyText' => 'This investigation does not contain any document records in the current workspace yet.',
        ],
    ];


    $activeSectionMeta = $sectionMeta[$section] ?? null;


    $workspaceTitle = match ($section) {
        'Evidence' => 'Evidence Workspace',
        'Witnesses' => 'Witnesses Workspace',
        'Suspects' => 'Suspects Workspace',
        'Timeline' => 'Timeline Workspace',
        'Notes' => 'Notes Workspace',
        'Documents' => 'Documents Workspace',
        'Board' => 'Investigation Board',
        default => $section,
    };
@endphp


        <main class="p-4 sm:p-6 lg:p-8 space-y-6 lg:space-y-8">
            <div class="executive-card p-6 sm:p-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <div class="text-sm uppercase tracking-[4px] text-amber-500">Director Orders</div>
                        <h1 class="mt-3 text-3xl sm:text-4xl font-bold text-white">{{ $case->title }}</h1>
                        <p class="mt-4 text-sm sm:text-base text-slate-400">{{ $case->description }}</p>
                    </div>


                    <div class="text-left lg:text-right">
                        <span class="rounded-full bg-blue-900 px-4 py-2 text-sm font-semibold text-blue-300">In Progress</span>
                    </div>
                </div>


                <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    <div>
                        <div class="text-xs uppercase tracking-widest text-slate-500">Mission Objective</div>
                        <div class="mt-2 text-white">Determine the truth behind this investigation.</div>
                    </div>


                    <div>
                        <div class="text-xs uppercase tracking-widest text-slate-500">Classification</div>
                        <div class="mt-2 font-semibold text-red-400">TOP SECRET</div>
                    </div>


                    <div>
                        <div class="text-xs uppercase tracking-widest text-slate-500">Priority</div>
                        <div class="mt-2 font-semibold text-amber-400">HIGH</div>
                    </div>


                    <div>
                        <div class="text-xs uppercase tracking-widest text-slate-500">Last Order</div>
                        <div class="mt-2 text-white">Review every document before submitting your final report.</div>
                    </div>
                </div>
            </div>


            <div class="grid gap-6 lg:grid-cols-2">
                <div class="executive-card p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg sm:text-xl font-bold text-white">Investigation Progress</h2>
                        <span class="text-sm font-semibold text-amber-400">{{ $stats['unlockedFiles'] }}/{{ $stats['totalFiles'] }}</span>
                    </div>


                    @php
                        $progress = $stats['totalFiles'] > 0 ? round(($stats['unlockedFiles'] / $stats['totalFiles']) * 100) : 0;
                    @endphp


                    <div class="mt-6">
                        <div class="mb-2 flex justify-between text-sm">
                            <span class="text-slate-500">Progress</span>
                            <span class="text-white">{{ $progress }}%</span>
                        </div>


                        <div class="h-3 overflow-hidden rounded-full bg-slate-800">
                            <div class="h-3 rounded-full bg-amber-600" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                </div>


                <div class="executive-card p-6">
                    <h2 class="text-lg sm:text-xl font-bold text-white">Mission Objectives</h2>


                    <ul class="mt-6 space-y-4">
                        <li class="flex items-center gap-3">
                            <span class="text-green-400">●</span>
                            <span class="text-slate-300">Read the Incident Report</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-slate-500">●</span>
                            <span class="text-slate-300">Examine all Evidence Files</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-slate-500">●</span>
                            <span class="text-slate-300">Review Witness Statements</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-slate-500">●</span>
                            <span class="text-slate-300">Submit Final Report</span>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
                <div class="executive-card p-5">
                    <div class="text-slate-500">Total Files</div>
                    <div class="mt-3 text-3xl font-bold text-white">{{ $stats['totalFiles'] }}</div>
                </div>


                <div class="executive-card p-5">
                    <div class="text-slate-500">Locked</div>
                    <div class="mt-3 text-3xl font-bold text-red-400">{{ $stats['lockedFiles'] }}</div>
                </div>


                <div class="executive-card p-5">
                    <div class="text-slate-500">Unlocked</div>
                    <div class="mt-3 text-3xl font-bold text-green-400">{{ $stats['unlockedFiles'] }}</div>
                </div>


                <div class="executive-card p-5">
                    <div class="text-slate-500">Sections</div>
                    <div class="mt-3 text-3xl font-bold text-white">{{ $stats['totalSections'] }}</div>
                </div>


                <div class="executive-card p-5 sm:col-span-2 xl:col-span-1">
                    <div class="text-slate-500">Last Updated</div>
                    <div class="mt-3 text-sm font-semibold text-white">
                        {{ $stats['lastUpdated'] ? $stats['lastUpdated']->format('Y-m-d H:i') : '-' }}
                    </div>
                </div>
            </div>


           
                <div class="grid gap-6 xl:grid-cols-4">
                    <div class="xl:col-span-3 space-y-6">
                        <div class="executive-card p-6">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                <div>
                                    <h2 class="text-lg sm:text-xl font-bold text-white">Investigation Workspace</h2>
                                    <p class="mt-2 text-sm text-slate-400">Access investigation materials by workspace section.</p>
                                </div>


                                <div class="rounded-lg border border-slate-800 bg-slate-900 px-4 py-3 text-sm text-slate-300">
                                    Active Section <span class="font-semibold text-white">{{ $section }}</span>
                                </div>
                            </div>


                            @include('dashboard.partials.case-workspace-navigation', [
                                'navSections' => $navSections,
                                'case' => $case,
                                'section' => $section,
                                'containerClass' => 'mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6',
                                'linkClass' => 'rounded-lg border px-4 py-3 text-sm font-medium transition',
                                'activeClass' => 'border-amber-500 bg-amber-500/10 text-white',
                                'inactiveClass' => 'border-slate-700 bg-slate-900 text-slate-300 hover:border-amber-500 hover:text-white',
                            ])


                            @if($section === 'Evidence')
                                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                                    <div class="executive-card p-5">
                                        <div class="text-xs uppercase tracking-widest text-slate-500">Evidence Records</div>
                                        <div class="mt-3 text-2xl font-bold text-white">{{ $files->count() }}</div>
                                    </div>


                                    <div class="executive-card p-5">
                                        <div class="text-xs uppercase tracking-widest text-slate-500">Locked Evidence</div>
                                        <div class="mt-3 text-2xl font-bold text-red-400">{{ $files->where('locked', true)->count() }}</div>
                                    </div>


                                    <div class="executive-card p-5">
                                        <div class="text-xs uppercase tracking-widest text-slate-500">Accessible Evidence</div>
                                        <div class="mt-3 text-2xl font-bold text-green-400">{{ $files->where('locked', false)->count() }}</div>
                                    </div>
                                </div>
                            @endif


                            @if($activeSectionMeta)
                                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                                    <div class="executive-card p-5">
                                        <div class="text-xs uppercase tracking-widest text-slate-500">{{ $activeSectionMeta['statsLabel'] }}</div>
                                        <div class="mt-3 text-2xl font-bold text-white">{{ $files->count() }}</div>
                                    </div>


                                    <div class="executive-card p-5">
                                        <div class="text-xs uppercase tracking-widest text-slate-500">{{ $activeSectionMeta['lockedLabel'] }}</div>
                                        <div class="mt-3 text-2xl font-bold text-red-400">{{ $files->where('locked', true)->count() }}</div>
                                    </div>


                                    <div class="executive-card p-5">
                                        <div class="text-xs uppercase tracking-widest text-slate-500">{{ $activeSectionMeta['availableLabel'] }}</div>
                                        <div class="mt-3 text-2xl font-bold text-green-400">{{ $files->where('locked', false)->count() }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>


                        <div class="executive-card overflow-hidden">
                            <div class="border-b border-slate-800 bg-slate-900/70 px-5 py-4 sm:px-8 sm:py-5">
                                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                    <h2 class="text-lg sm:text-xl font-bold uppercase tracking-widest text-white">{{ $workspaceTitle }}</h2>
                                    <span class="text-sm text-slate-500">{{ $files->count() }} Files</span>
                                </div>
                            </div>


                            @if($activeSectionMeta)
                                <div class="p-5 sm:p-8">
                                    @forelse($files as $file)
                                        @php
                                            $isTimeline = $section === 'Timeline';
                                        @endphp


                                        @if($isTimeline)
                                            <div class="relative pl-8 sm:pl-10 {{ !$loop->last ? 'pb-6' : '' }}">
                                                <div class="absolute left-3 top-0 h-full w-px bg-slate-800 {{ $loop->last ? 'hidden' : '' }}"></div>
                                                <div class="absolute left-0 top-6 flex h-6 w-6 items-center justify-center rounded-full border border-slate-700 bg-slate-950">
                                                    <div class="h-2.5 w-2.5 rounded-full {{ $file->locked ? 'bg-red-400' : 'bg-green-400' }}"></div>
                                                </div>
                                        @endif


                                        <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-5 sm:p-6 {{ !$isTimeline && !$loop->last ? 'mb-4' : '' }}">
                                            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                                                <div class="min-w-0 flex-1">
                                                    <div class="flex flex-wrap items-center gap-3">
                                                        <h3 class="text-base sm:text-lg font-semibold text-white">{{ $file->title }}</h3>


                                                        @if($file->locked)
                                                            <span class="rounded-full border border-red-800 bg-red-950/60 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-red-300">Locked</span>
                                                        @else
                                                            <span class="rounded-full border border-green-800 bg-green-950/60 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-green-300">Available</span>
                                                        @endif
                                                    </div>


                                                    @if($file->description)
                                                        <p class="mt-4 text-sm sm:text-base leading-6 text-slate-300">{{ $file->description }}</p>
                                                    @endif


                                                    <div class="mt-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                                                        <div class="rounded-lg border border-slate-800 bg-slate-950/60 px-4 py-3">
                                                            <div class="text-[11px] uppercase tracking-[0.2em] text-slate-500">{{ $activeSectionMeta['metaTitle'] }}</div>
                                                            <div class="mt-2 text-sm font-medium text-white">{{ $file->title }}</div>
                                                        </div>


                                                        <div class="rounded-lg border border-slate-800 bg-slate-950/60 px-4 py-3">
                                                            <div class="text-[11px] uppercase tracking-[0.2em] text-slate-500">Display Order</div>
                                                            <div class="mt-2 text-sm font-medium text-white">{{ $file->display_order }}</div>
                                                        </div>


                                                        <div class="rounded-lg border border-slate-800 bg-slate-950/60 px-4 py-3 sm:col-span-2 xl:col-span-1">
                                                            <div class="text-[11px] uppercase tracking-[0.2em] text-slate-500">Last Updated</div>
                                                            <div class="mt-2 text-sm font-medium text-white">{{ $file->updated_at ? $file->updated_at->format('Y-m-d H:i') : '-' }}</div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="w-full lg:w-auto lg:min-w-[170px]">
                                                    @if($file->locked)
                                                        <div class="rounded-xl border border-red-900 bg-red-950/40 px-5 py-4 text-center">
                                                            <div class="text-sm font-semibold text-red-300">Locked</div>
                                                            <div class="mt-1 text-xs text-red-400">{{ $activeSectionMeta['lockedText'] }}</div>
                                                        </div>
                                                    @else
                                                        <a href="{{ route('case-files.show', ['case' => $case, 'file' => $file->id]) }}"
                                                           class="inline-flex w-full items-center justify-center rounded-xl bg-amber-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-amber-500 lg:w-auto">
                                                            {{ $activeSectionMeta['buttonText'] }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>


                                        @if($isTimeline)
                                            </div>
                                        @endif
                                    @empty
                                        <div class="p-8 text-center sm:p-12">
                                            <div class="text-5xl sm:text-6xl">📁</div>
                                            <h3 class="mt-6 text-xl sm:text-2xl font-bold text-white">{{ $activeSectionMeta['emptyTitle'] }}</h3>
                                            <p class="mt-3 text-sm sm:text-base text-slate-500">{{ $activeSectionMeta['emptyText'] }}</p>
                                        </div>
                                    @endforelse
                                </div>
                            @else
                                @forelse($files as $file)
                                    <div class="border-b border-slate-900 px-5 py-5 last:border-b-0 sm:px-8">
                                        <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                                            <div class="min-w-0">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <h3 class="text-base sm:text-lg font-semibold text-white">{{ $file->title }}</h3>


                                                    @if($section === 'Evidence')
                                                        @if($file->locked)
                                                            <span class="rounded-full bg-red-900 px-3 py-1 text-xs font-semibold text-red-300">Locked</span>
                                                        @else
                                                            <span class="rounded-full bg-green-900 px-3 py-1 text-xs font-semibold text-green-300">Accessible</span>
                                                        @endif
                                                    @endif
                                                </div>


                                                <div class="mt-2 flex flex-wrap items-center gap-4 text-xs sm:text-sm text-slate-500">
                                                    @if($file->section)
                                                        <span>{{ $file->section }}</span>
                                                    @endif
                                                    <span>Order {{ $file->display_order }}</span>
                                                    @if($section === 'Evidence' && $file->updated_at)
                                                        <span>Updated {{ $file->updated_at->format('Y-m-d H:i') }}</span>
                                                    @endif
                                                </div>


                                                @if($file->description)
                                                    <p class="mt-3 text-sm sm:text-base text-slate-400">{{ $file->description }}</p>
                                                @endif
                                            </div>


                                            <div class="shrink-0">
                                                @if($file->locked)
                                                    <span class="inline-flex rounded-lg bg-red-900 px-5 py-3 text-sm font-semibold text-red-300">Locked</span>
                                                @else
                                                    <a href="{{ route('case-files.show', ['case' => $case, 'file' => $file->id]) }}"
                                                       class="inline-flex rounded-lg bg-amber-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-amber-500">
                                                        {{ $section === 'Evidence' ? 'Open Evidence' : 'Open File' }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center sm:p-12">
                                        <div class="text-5xl sm:text-6xl">📁</div>
                                        <h3 class="mt-6 text-xl sm:text-2xl font-bold text-white">{{ $section === 'Evidence' ? 'No Evidence Files' : 'No Investigation Files' }}</h3>
                                        <p class="mt-3 text-sm sm:text-base text-slate-500">
                                            {{ $section === 'Evidence'
                                                ? 'This investigation does not contain any evidence records in the current workspace yet.'
                                                : 'This investigation does not contain any files yet.' }}
                                        </p>
                                    </div>
                                @endforelse
                            @endif
                        </div>
                    </div>


                    <div class="space-y-6">
                        <div class="executive-card p-6">
                            <h2 class="text-lg font-bold text-white">Investigation Workspace</h2>


                            @include('dashboard.partials.case-workspace-navigation', [
                                'navSections' => $navSections,
                                'case' => $case,
                                'section' => $section,
                                'containerClass' => 'mt-6 space-y-3',
                                'linkClass' => 'block rounded-lg border px-4 py-3 text-left transition',
                                'activeClass' => 'border-amber-500 bg-amber-500/10 text-white',
                                'inactiveClass' => 'border-slate-700 bg-slate-900 text-white hover:border-amber-500',
                            ])
                        </div>


                        <div class="executive-card p-6">
                            <h2 class="text-lg font-bold text-white">Section Brief</h2>


                            <div class="mt-6 space-y-4 text-sm">
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-slate-500">Active Section</span>
                                    <span class="font-semibold text-white">{{ $section }}</span>
                                </div>


                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-slate-500">Visible Files</span>
                                    <span class="font-semibold text-white">{{ $files->count() }}</span>
                                </div>


                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-slate-500">Locked Files</span>
                                    <span class="font-semibold text-red-400">{{ $files->where('locked', true)->count() }}</span>
                                </div>


                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-slate-500">Accessible Files</span>
                                    <span class="font-semibold text-green-400">{{ $files->where('locked', false)->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           


        </main>
@endsection