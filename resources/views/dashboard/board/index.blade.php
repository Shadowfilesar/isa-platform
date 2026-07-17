@extends('layouts.app')

@section('title', ($case->title ?? 'Mission') . ' Board')
@section('page-title', ($case->title ?? 'Mission') . ' Board')
@section('page-description', 'Investigation workspace')
@section('body_class', 'investigation-mode')
@section('workspace_mode', 'investigation')

@section('content')
@php
    $boardFiles = $boardFiles ?? $case->files()->orderBy('section')->orderBy('display_order')->get();

    $missionCode = $case->mission_code
        ?? $case->code
        ?? ('MISSION-' . str_pad((string) $case->id, 4, '0', STR_PAD_LEFT));

    $classification = strtoupper($case->classification ?? 'TOP SECRET');

    $status = $case->status
        ?? ($case->is_completed ?? false ? 'Completed' : 'Active');

    $agentCode = auth()->user()->accountcode
        ?? auth()->user()->agent_code
        ?? auth()->user()->code
        ?? 'AGENT-000';

    $backUrl = route('cases.show', $case);
@endphp

<div class="investigation-board-page" data-workspace-mode="investigation">
    <section
        class="investigation-board"
        data-board-app
        data-case-id="{{ $case->id }}"
        aria-label="Investigation Board Workspace"
    >
        @include('dashboard.board.toolbar', [
            'case' => $case,
            'missionCode' => $missionCode,
            'classification' => $classification,
            'status' => $status,
            'agentCode' => $agentCode,
            'backUrl' => $backUrl,
        ])

        <div class="board-main">
            @include('dashboard.board.sidebar', ['boardFiles' => $boardFiles])

            <section class="board-canvas-shell" aria-label="Investigation canvas">
                <div class="board-canvas" id="board-canvas">
                    <div class="board-background" aria-hidden="true"></div>
                    <div class="board-grid" aria-hidden="true"></div>
                    <svg class="board-connections" id="board-connections" aria-hidden="true"></svg>

                    <div class="board-items" id="board-items" data-board-items>
                        <div class="board-empty-state">
                            <div class="board-empty-state-inner">
                                <span class="board-empty-state-kicker">Investigation Workspace</span>
                                <h2 class="board-empty-state-title">{{ $case->title ?? 'Mission Board' }}</h2>
                                <p class="board-empty-state-text">
                                    The canvas is prepared for evidence placement, zoom, pan, connections, sticky notes, and future mission analysis workflows.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <aside class="board-inspector" aria-label="Inspector panel">
                <div class="board-card board-inspector-card">
                    <div class="board-title">Inspector</div>

                    <div class="board-inspector-section">
                        <h3 class="board-inspector-heading">Mission Context</h3>
                        <p class="board-inspector-text">
                            Select a board item to inspect linked evidence, notes, and future connection details inside this panel.
                        </p>
                    </div>

                    <div class="board-inspector-metrics">
                        <div class="board-inspector-metric">
                            <span class="board-inspector-label">Mission</span>
                            <strong class="board-inspector-value">{{ $missionCode }}</strong>
                        </div>

                        <div class="board-inspector-metric">
                            <span class="board-inspector-label">Canvas</span>
                            <strong class="board-inspector-value">5000 × 5000</strong>
                        </div>

                        <div class="board-inspector-metric">
                            <span class="board-inspector-label">Mode</span>
                            <strong class="board-inspector-value">Investigation</strong>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</div>
@endsection