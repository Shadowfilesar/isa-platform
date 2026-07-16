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
            'stats_label' => 'Witness Records',
            'locked_label' => 'Locked Witnesses',
            'available_label' => 'Available Witnesses',
            'workspace_title' => 'Witnesses Workspace',
            'meta_title' => 'Witness File',
            'locked_text' => 'Witness statement restricted',
            'button_text' => 'Open Statement',
            'empty_title' => 'No Witness Files',
            'empty_text' => 'This investigation does not contain any witness records in the current workspace yet.',
        ],
        'Suspects' => [
            'stats_label' => 'Suspect Dossiers',
            'locked_label' => 'Locked Dossiers',
            'available_label' => 'Available Dossiers',
            'workspace_title' => 'Suspects Workspace',
            'meta_title' => 'Suspect Name',
            'locked_text' => 'Suspect dossier restricted',
            'button_text' => 'Open Dossier',
            'empty_title' => 'No Suspect Files',
            'empty_text' => 'This investigation does not contain any suspect records in the current workspace yet.',
        ],
        'Timeline' => [
            'stats_label' => 'Timeline Entries',
            'locked_label' => 'Locked Entries',
            'available_label' => 'Available Entries',
            'workspace_title' => 'Timeline Workspace',
            'meta_title' => 'Timeline Entry',
            'locked_text' => 'Timeline entry restricted',
            'button_text' => 'Open File',
            'empty_title' => 'No Timeline Files',
            'empty_text' => 'This investigation does not contain any timeline records in the current workspace yet.',
        ],
        'Notes' => [
            'stats_label' => 'Case Notes',
            'locked_label' => 'Locked Notes',
            'available_label' => 'Available Notes',
            'workspace_title' => 'Notes Workspace',
            'meta_title' => 'Note Title',
            'locked_text' => 'Case note restricted',
            'button_text' => 'Open File',
            'empty_title' => 'No Note Files',
            'empty_text' => 'This investigation does not contain any note records in the current workspace yet.',
        ],
        'Documents' => [
            'stats_label' => 'Case Documents',
            'locked_label' => 'Locked Documents',
            'available_label' => 'Available Documents',
            'workspace_title' => 'Documents Workspace',
            'meta_title' => 'Document Title',
            'locked_text' => 'Document access restricted',
            'button_text' => 'Open File',
            'empty_title' => 'No Document Files',
            'empty_text' => 'This investigation does not contain any document records in the current workspace yet.',
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

    $boardFiles = $case->files()
        ->orderBy('section')
        ->orderBy('display_order')
        ->get();

    $boardSections = $boardFiles->pluck('section')->filter()->unique()->values();

    $pinnedBoardFiles = $boardFiles->take(6)->values();
    $sidebarBoardFiles = $boardFiles->slice($pinnedBoardFiles->count())->values();

    $boardStats = [
        'total' => $boardFiles->count(),
        'locked' => $boardFiles->where('locked', true)->count(),
        'available' => $boardFiles->where('locked', false)->count(),
        'sections' => $boardSections->count(),
        'pinned' => $pinnedBoardFiles->count(),
        'remaining' => $sidebarBoardFiles->count(),
    ];

    $boardItemStyles = [
        [
            'desktop' => 'left-[4%] top-[5%] w-[170px] rotate-[-2deg] 2xl:w-[190px]',
            'mobile' => 'w-[88%] max-w-[240px] rotate-[-1deg]',
            'thumb' => 'aspect-[4/3]',
            'surface' => 'bg-[#f0e6d2]',
        ],
        [
            'desktop' => 'left-[28%] top-[3%] w-[210px] rotate-[1.5deg] 2xl:w-[235px]',
            'mobile' => 'w-[92%] max-w-[280px] rotate-[1deg]',
            'thumb' => 'aspect-[3/2]',
            'surface' => 'bg-[#efe3ce]',
        ],
        [
            'desktop' => 'right-[8%] top-[9%] w-[158px] rotate-[-1.25deg] 2xl:w-[174px]',
            'mobile' => 'w-[84%] max-w-[220px] rotate-[-1deg]',
            'thumb' => 'aspect-[3/4]',
            'surface' => 'bg-[#f1e7d3]',
        ],
        [
            'desktop' => 'left-[12%] top-[43%] w-[195px] rotate-[2.25deg] 2xl:w-[220px]',
            'mobile' => 'w-[90%] max-w-[270px] rotate-[1deg]',
            'thumb' => 'aspect-[5/4]',
            'surface' => 'bg-[#eee2cc]',
        ],
        [
            'desktop' => 'left-[46%] top-[38%] w-[162px] rotate-[-2.5deg] 2xl:w-[178px]',
            'mobile' => 'w-[82%] max-w-[225px] rotate-[-1deg]',
            'thumb' => 'aspect-[3/5]',
            'surface' => 'bg-[#f3e8d5]',
        ],
        [
            'desktop' => 'right-[10%] bottom-[12%] w-[248px] rotate-[1.75deg] 2xl:w-[286px]',
            'mobile' => 'w-[94%] max-w-[300px] rotate-[1deg]',
            'thumb' => 'aspect-[16/10]',
            'surface' => 'bg-[#efe4cf]',
        ],
    ];
@endphp

<div class="min-h-screen flex">
    @include('dashboard.partials.sidebar')

    <div class="flex-1">
        @include('dashboard.partials.header')
        @include('dashboard.partials.breadcrumb')
        @include('dashboard.partials.alerts')

        <main class="p-4 sm:p-6 lg:p-8 space-y-6 lg:space-y-8">
            <div class="executive-card p-6 sm:p-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <div class="text-sm uppercase tracking-[4px] text-amber-500">Director Orders</div>
                        <h1 class="mt-3 text-3xl sm:text-4xl font-bold text-white">{{ $case->title }}</h1>
                        <p class="mt-4 text-sm sm:text-base text-slate-400">{{ $case->description }}</p>
                    </div>

                    <div class="text-left lg:text-right">
                        <span class="rounded-full bg-blue-900 px-4 py-2 text-sm font-semibold text-blue-300">
                            🔍 In Progress
                        </span>
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
                            <span class="text-green-400">✔</span>
                            <span class="text-slate-300">Read the Incident Report</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-slate-500">○</span>
                            <span class="text-slate-300">Examine all Evidence Files</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-slate-500">○</span>
                            <span class="text-slate-300">Review Witness Statements</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-slate-500">○</span>
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

            @if($section === 'Board')
                <section class="space-y-6">
                    <div class="executive-card p-6 sm:p-8">
                        <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                            <div class="max-w-3xl">
                                <div class="text-xs uppercase tracking-[0.35em] text-amber-500">ISA Investigation Board</div>
                                <h2 class="mt-3 text-2xl sm:text-3xl xl:text-4xl font-bold text-white">
                                    Active Analysis Surface
                                </h2>
                                <p class="mt-4 text-sm sm:text-base leading-7 text-slate-400">
                                    Review pinned evidence, inspect available case files, and move between the board preview
                                    and the investigation viewer without leaving the case workspace.
                                </p>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-1 xl:min-w-[260px]">
                                <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-5 py-4">
                                    <div class="text-[11px] uppercase tracking-[0.25em] text-slate-500">Board Status</div>
                                    <div class="mt-2 text-sm font-semibold text-emerald-300">Visual Layout Active</div>
                                </div>
                                <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-5 py-4">
                                    <div class="text-[11px] uppercase tracking-[0.25em] text-slate-500">Pinned Files</div>
                                    <div class="mt-2 text-sm font-semibold text-white">{{ $boardStats['pinned'] }} Board Cards</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-4 lg:grid-cols-2 2xl:grid-cols-4">
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-4">
                            <div class="text-[11px] uppercase tracking-[0.22em] text-slate-500">Canvas Profile</div>
                            <div class="mt-2 text-base font-semibold text-white">Immersive Detective Layout</div>
                            <p class="mt-3 text-sm leading-6 text-slate-400">Large screens now present evidence as a premium investigation wall rather than a dashboard card grid.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-4">
                            <div class="text-[11px] uppercase tracking-[0.22em] text-slate-500">Card Sizing</div>
                            <div class="mt-2 text-base font-semibold text-white">Compact Evidence Cards</div>
                            <p class="mt-3 text-sm leading-6 text-slate-400">Mixed thumbnail proportions keep the board realistic while preserving room for many future board objects.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-4">
                            <div class="text-[11px] uppercase tracking-[0.22em] text-slate-500">Viewer Access</div>
                            <div class="mt-2 text-base font-semibold text-white">Existing File Flow</div>
                            <p class="mt-3 text-sm leading-6 text-slate-400">Every evidence card continues to open the current case file viewer experience.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-4">
                            <div class="text-[11px] uppercase tracking-[0.22em] text-slate-500">Future Ready</div>
                            <div class="mt-2 text-base font-semibold text-white">Reserved Workspace</div>
                            <p class="mt-3 text-sm leading-6 text-slate-400">Natural empty space remains available for future lines, labels, notes, and reasoning indicators.</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-white">Evidence Locker</h3>
                            <p class="mt-2 text-sm text-slate-400">
                                Drag the unlocked files directly onto the board. Pinned files keep their saved positions, rotation, size, and connections.
                            </p>
                        </div>

                        <div class="flex items-center gap-3 text-sm text-slate-300">
                            <span class="rounded-xl border border-slate-800 bg-slate-900 px-4 py-2">Pinned {{ $boardStats['pinned'] }}</span>
                            <span class="rounded-xl border border-slate-800 bg-slate-900 px-4 py-2">Available {{ $boardStats['available'] }}</span>
                        </div>
                    </div>

                    <div class="board-lab investigation-board-page">
                        <div class="board-labambient"></div>
                        <div class="board-labgrid"></div>

                        <div class="investigation-board-workspace"
                             data-board-app
                             data-case-id="{{ $case->id }}"
                             data-player-id="{{ $player->id ?? '' }}"
                             data-fetch-url="{{ route('investigation-board.show', ['case' => $case]) }}"
                             data-autosave-url="{{ route('investigation-board.autosave', ['case' => $case]) }}"
                             data-unpin-template="{{ route('investigation-board.unpin', ['case' => $case, 'file' => 'FILE']) }}"
                             data-move-template="{{ route('investigation-board.move', ['case' => $case, 'item' => 'ITEM']) }}"
                             data-resize-template="{{ route('investigation-board.resize', ['case' => $case, 'item' => 'ITEM']) }}"
                             data-front-template="{{ route('investigation-board.bring-to-front', ['case' => $case, 'item' => 'ITEM']) }}"
                             data-connections-template="{{ route('investigation-board.connections.store', ['case' => $case]) }}"
                             data-delete-connection-template="{{ route('investigation-board.connections.destroy', ['case' => $case, 'connection' => 'CONNECTION']) }}"
                             data-csrf="{{ csrf_token() }}">
                            <div class="board-stagetoolbar investigation-toolbar">
                                <div class="board-stagetitle-block">
                                    <div class="eyebrow">Investigation Workspace</div>
                                    <h2>Evidence Correlation Board</h2>
                                    <p>Drag evidence directly onto the desk, scatter files naturally, connect clues visually, and work the case like a real field board.</p>
                                </div>

                                <div class="board-stagetoolbar-right">
                                    <button type="button" class="board-tool-btn" data-board-zoom-out aria-label="Zoom out">−</button>
                                    <button type="button" class="board-tool-btn" data-board-zoom-reset aria-label="Reset zoom">100%</button>
                                    <button type="button" class="board-tool-btn" data-board-zoom-in aria-label="Zoom in">+</button>
                                    <button type="button" class="board-tool-btn" data-board-focus-toggle aria-pressed="false">Focus Mode</button>
                                </div>
                            </div>

                            <div class="board-layout investigation-board-layout">
                                <aside class="board-evidence-drawer investigation-drawer">
                                    <div class="drawer-header">
                                        <div>
                                            <div class="eyebrow">Evidence Locker</div>
                                            <h3>Drag onto Board</h3>
                                        </div>
                                        <span class="drawer-count">{{ $boardStats['available'] ?? $boardStats['remaining'] }}</span>
                                    </div>

                                    <div class="drawer-scroll">
                                        @forelse($boardFiles as $file)
                                            @php
                                                $style = $boardItemStyles[$loop->index % count($boardItemStyles)];
                                            @endphp
                                            <article class="drawer-evidence investigation-evidence-source {{ $file->locked ? 'is-locked' : '' }}"
                                                     data-evidence-source
                                                     data-file-id="{{ $file->id }}"
                                                     data-file-title="{{ e($file->title) }}"
                                                     data-file-section="{{ e($file->section ?: 'Evidence') }}"
                                                     data-file-type="{{ e($file->file_type) }}"
                                                     data-file-category="{{ e($file->category) }}"
                                                     data-file-url="{{ route('case-files.show', ['case' => $case, 'file' => $file->id]) }}"
                                                     data-file-pin-url="{{ route('investigation-board.pin', ['case' => $case, 'file' => 'FILE_ID']) }}"
                                                     data-file-description="{{ e($file->description) }}"
                                                     data-file-locked="{{ $file->locked ? 1 : 0 }}"
                                                     draggable="{{ $file->locked ? 'false' : 'true' }}">
                                                <div class="drawer-evidencepin"></div>
                                                <div class="drawer-evidencetape drawer-evidencetape--left"></div>
                                                <div class="drawer-evidencetape drawer-evidencetape--right"></div>
                                                <div class="drawer-evidencepreview drawer-evidencepreview--{{ $file->category }}">
                                                    {!! $file->preview_html ?? '' !!}
                                                    @if($file->locked)
                                                        <div class="drawer-evidencelocked">Locked</div>
                                                    @endif
                                                </div>

                                                <div class="drawer-evidencecontent">
                                                    <div class="drawer-evidencehead">
                                                        <div>
                                                            <h4>{{ $file->title }}</h4>
                                                            <p>{{ $file->section }} {{ $file->file_type }}</p>
                                                        </div>
                                                        <span class="drawer-evidenceorder">{{ $file->z_index }}</span>
                                                    </div>

                                                    <p class="drawer-evidencedescription">
                                                        {{ $file->description ? \Illuminate\Support\Str::limit($file->description, 220) : 'No summary available.' }}
                                                    </p>

                                                    <div class="drawer-evidenceactions">
                                                        @if($file->locked)
                                                            <span class="drawer-lock-label">Restricted</span>
                                                        @else
                                                            <a href="{{ route('case-files.show', ['case' => $case, 'file' => $file->id]) }}"
                                                               class="drawer-action-link" target="_blank" rel="noopener noreferrer">Open File</a>
                                                            <span class="drawer-drag-label">Drag to board</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </article>
                                        @empty
                                            <div class="drawer-empty">No evidence files available.</div>
                                        @endforelse
                                    </div>
                                </aside>

                                <section class="board-workspace-panel investigation-workspace">
                                    <div class="board-canvas-shell investigation-canvas-shell">
                                        <div class="board-canvas-shellsurface investigation-canvas-surface" data-board-dropzone>
                                            <div class="board-cork-board"></div>
                                            <div class="board-cork-boardgrain"></div>
                                            <div class="board-cork-boardfibers"></div>
                                            <div class="board-cork-boardvignette"></div>
                                            <div class="board-cork-boardpushpins"></div>
                                            <div class="board-cork-boardlampglow board-cork-boardlampglow--a"></div>
                                            <div class="board-cork-boardlampglow board-cork-boardlampglow--b"></div>
                                            <div class="board-cork-boarddrop-hint" data-drop-hint>Drop evidence anywhere on the board</div>

                                            <div class="board-atmosphere"></div>
                                            <div class="board-atmosphere"></div>
                                            <div class="board-atmosphere"></div>

                                            <div class="board-desk-shadow board-desk-shadow--top"></div>
                                            <div class="board-desk-shadow board-desk-shadow--bottom"></div>

                                            <div class="board-notes-layer">
                                                <div class="board-note">Focus on motive first.</div>
                                                <div class="board-note">Connections persist after autosave.</div>
                                                <div class="board-note">Pinned evidence keeps z-index order.</div>
                                            </div>

                                            <div class="board-panzoom" data-board-panzoom>
                                                <svg class="board-connections-layer" data-board-connections-svg></svg>
                                                <svg class="board-connections-preview-layer" data-board-preview-svg></svg>
                                                <div class="board-items-layer" data-board-items-layer></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="board-statusbar investigation-statusbar">
                                        <div class="status-cluster">
                                            <span class="status-label">Saved Evidence</span>
                                            <strong data-board-item-count>{{ $existingBoardItems->count() }}</strong>
                                        </div>
                                        <div class="status-cluster">
                                            <span class="status-label">Connections</span>
                                            <strong data-board-connection-count>{{ $connectionSummary['total'] ?? 0 }}</strong>
                                        </div>
                                        <div class="status-cluster">
                                            <span class="status-label">Visible</span>
                                            <strong data-board-visible-count>{{ $connectionSummary['visible'] ?? 0 }}</strong>
                                        </div>
                                        <div class="status-cluster">
                                            <span class="status-label">Mode</span>
                                            <strong data-board-mode-label>Standard</strong>
                                        </div>
                                    </div>

                                    <template data-board-sticky-note-template>
                                        <article class="board-item board-item--sticky board-item--selected" data-board-item>
                                            <div class="board-itempin board-itempin--sticky"></div>
                                            <div class="board-itembody board-itembody--sticky">
                                                <div class="sticky-note-tape"></div>
                                                <textarea class="sticky-note-textarea" placeholder="Add note..."></textarea>
                                            </div>
                                        </article>
                                    </template>
                                </section>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            <div class="grid gap-6 xl:grid-cols-4">
                <div class="xl:col-span-3 space-y-6">
                    <div class="executive-card p-6">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <h2 class="text-lg sm:text-xl font-bold text-white">Investigation Workspace</h2>
                                <p class="mt-2 text-sm text-slate-400">Access investigation materials by workspace section.</p>
                            </div>

                            <div class="rounded-lg border border-slate-800 bg-slate-900 px-4 py-3 text-sm text-slate-300">
                                Active Section:
                                <span class="font-semibold text-white">{{ $section }}</span>
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
                    </div>

                    @if($section !== 'Board')
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
                                                        <p class="mt-3 text-sm sm:text-base text-slate-400">
                                                            {{ $file->description }}
                                                        </p>
                                                    @endif
                                                </div>

                                                <div class="shrink-0">
                                                    @if($file->locked)
                                                        <span class="inline-flex rounded-lg bg-red-900 px-5 py-3 text-sm font-semibold text-red-300">
                                                            🔒 Locked
                                                        </span>
                                                    @else
                                                        <a href="{{ route('case-files.show', ['case' => $case, 'file' => $file->id]) }}"
                                                           class="inline-flex rounded-lg bg-amber-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-amber-500">
                                                            {{ $section === 'Evidence' ? 'Open Evidence' : 'Open File' }}
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
                                            <h3 class="mt-6 text-xl sm:text-2xl font-bold text-white">
                                                {{ $section === 'Evidence' ? 'No Evidence Files' : 'No Investigation Files' }}
                                            </h3>
                                            <p class="mt-3 text-sm sm:text-base text-slate-500">
                                                {{ $section === 'Evidence'
                                                    ? 'This investigation does not contain any evidence records in the current workspace yet.'
                                                    : 'This investigation does not contain any files yet.' }}
                                            </p>
                                        </div>
                                    @endforelse
                                </div>
                            @endif
                        </div>
                    @endif
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
    </div>
</div>
@endsection