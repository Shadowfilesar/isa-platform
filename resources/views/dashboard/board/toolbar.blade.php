@php
    $missionCode = $missionCode ?? ($case->mission_code ?? $case->code ?? ('MISSION-' . str_pad((string) $case->id, 4, '0', STR_PAD_LEFT)));
    $classification = strtoupper($classification ?? ($case->classification ?? 'TOP SECRET'));
    $status = $status ?? ($case->status ?? 'Active');
    $agentCode = $agentCode ?? (auth()->user()->accountcode ?? auth()->user()->agent_code ?? auth()->user()->code ?? 'AGENT-000');
    $backUrl = $backUrl ?? route('cases.show', $case);
@endphp

<header class="board-mission-header" aria-label="Mission navigation header">
    <div class="board-mission-header__left">
        <a href="{{ $backUrl }}" class="board-mission-back" aria-label="Back to Mission">
            <span class="board-mission-back__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </span>
            <span class="board-mission-back__label">Back to Mission</span>
        </a>

        <div class="board-mission-meta">
            <div class="board-mission-code">{{ $missionCode }}</div>

            <div class="board-mission-badges">
                <span class="board-mission-badge board-mission-badge--classification">
                    {{ $classification }}
                </span>
                <span class="board-mission-badge board-mission-badge--status">
                    {{ $status }}
                </span>
            </div>
        </div>
    </div>

    <div class="board-mission-header__center">
        <div class="board-toolbar" role="toolbar" aria-label="Investigation tools">
            <div class="board-toolbar-group board-toolbar-group--primary">
                <button
                    type="button"
                    class="board-toolbar-button is-active"
                    data-tool="select"
                    data-tooltip="Select"
                    aria-pressed="true"
                >
                    <span class="board-tool-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M6 4l11 8-5 1.2L14 20l-2.4 1-2-6.7L6 4Z" fill="currentColor"></path>
                        </svg>
                    </span>
                    <span class="board-tool-label">Select</span>
                </button>

                <button
                    type="button"
                    class="board-toolbar-button"
                    data-tool="hand"
                    data-tooltip="Hand"
                    aria-pressed="false"
                >
                    <span class="board-tool-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M8 11V5.8a1.8 1.8 0 1 1 3.6 0V10m0-5.2a1.8 1.8 0 1 1 3.6 0V10m-7.2 1V8.2a1.8 1.8 0 1 0-3.6 0V15a5 5 0 0 0 5 5h3.4a5.2 5.2 0 0 0 4.94-3.58L19 12.4a1.8 1.8 0 1 0-3.46-1.12L14.8 13" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                    <span class="board-tool-label">Hand</span>
                </button>

                <button
                    type="button"
                    class="board-toolbar-button"
                    data-tool="connect"
                    data-tooltip="Connect"
                    aria-pressed="false"
                >
                    <span class="board-tool-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="6" cy="7" r="2.2" stroke="currentColor" stroke-width="1.6"></circle>
                            <circle cx="18" cy="6" r="2.2" stroke="currentColor" stroke-width="1.6"></circle>
                            <circle cx="12" cy="18" r="2.2" stroke="currentColor" stroke-width="1.6"></circle>
                            <path d="M8 8.3l2.5 6.2M16.2 7.7l-2.4 7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"></path>
                        </svg>
                    </span>
                    <span class="board-tool-label">Connect</span>
                </button>

                <button
                    type="button"
                    class="board-toolbar-button"
                    data-tool="note"
                    data-tooltip="Sticky Note"
                    aria-pressed="false"
                >
                    <span class="board-tool-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M7 4h10a2 2 0 0 1 2 2v7.5L13.5 19H7a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"></path>
                            <path d="M13 19v-4.2a1.8 1.8 0 0 1 1.8-1.8H19" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                    <span class="board-tool-label">Sticky Note</span>
                </button>
            </div>

            <div class="board-toolbar-divider" aria-hidden="true"></div>

            <div class="board-toolbar-group board-toolbar-group--zoom">
                <button
                    type="button"
                    class="board-toolbar-button"
                    data-board-zoom-out
                    data-tooltip="Zoom Out"
                    aria-label="Zoom Out"
                >
                    <span class="board-tool-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"></path>
                        </svg>
                    </span>
                </button>

                <button
                    type="button"
                    class="board-toolbar-button board-toolbar-button--zoom-readout"
                    data-board-zoom-reset
                    data-tooltip="Zoom Percentage"
                    aria-label="Zoom Percentage"
                >
                    <span class="board-tool-label">100%</span>
                </button>

                <button
                    type="button"
                    class="board-toolbar-button"
                    data-board-zoom-in
                    data-tooltip="Zoom In"
                    aria-label="Zoom In"
                >
                    <span class="board-tool-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"></path>
                        </svg>
                    </span>
                </button>

                <button
                    type="button"
                    class="board-toolbar-button"
                    data-tool="fit"
                    data-tooltip="Fit"
                    aria-label="Fit Board"
                >
                    <span class="board-tool-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M8 4H4v4M16 4h4v4M20 16v4h-4M4 16v4h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                    <span class="board-tool-label">Fit</span>
                </button>
            </div>

            <div class="board-toolbar-divider" aria-hidden="true"></div>

            <div class="board-toolbar-group board-toolbar-group--history">
                <button
                    type="button"
                    class="board-toolbar-button"
                    data-tool="undo"
                    data-tooltip="Undo"
                    aria-label="Undo"
                    disabled
                >
                    <span class="board-tool-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M9 8H5V4M5 8l4-4m0 4h5a5 5 0 1 1 0 10h-2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </button>

                <button
                    type="button"
                    class="board-toolbar-button"
                    data-tool="redo"
                    data-tooltip="Redo"
                    aria-label="Redo"
                    disabled
                >
                    <span class="board-tool-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M15 8h4V4m0 4-4-4m0 4h-5a5 5 0 1 0 0 10h2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </button>
            </div>

            <div class="board-toolbar-divider" aria-hidden="true"></div>

            <div class="board-toolbar-group board-toolbar-group--system">
                <button
                    type="button"
                    class="board-toolbar-button"
                    data-tool="fullscreen"
                    data-tooltip="Fullscreen"
                    aria-label="Fullscreen"
                >
                    <span class="board-tool-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M8 4H4v4M20 8V4h-4M16 20h4v-4M4 16v4h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </button>

                <button
                    type="button"
                    class="board-toolbar-button"
                    data-tool="settings"
                    data-tooltip="Settings"
                    aria-label="Settings"
                >
                    <span class="board-tool-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 8.8A3.2 3.2 0 1 1 8.8 12 3.2 3.2 0 0 1 12 8.8Z" stroke="currentColor" stroke-width="1.6"></path>
                            <path d="M19.4 15a1 1 0 0 0 .2 1.1l.1.1a1.2 1.2 0 0 1 0 1.7l-1.2 1.2a1.2 1.2 0 0 1-1.7 0l-.1-.1a1 1 0 0 0-1.1-.2 1 1 0 0 0-.6.9v.3a1.2 1.2 0 0 1-1.2 1.2h-1.7a1.2 1.2 0 0 1-1.2-1.2v-.2a1 1 0 0 0-.7-1 1 1 0 0 0-1.1.2l-.1.1a1.2 1.2 0 0 1-1.7 0l-1.2-1.2a1.2 1.2 0 0 1 0-1.7l.1-.1a1 1 0 0 0 .2-1.1 1 1 0 0 0-.9-.6h-.3A1.2 1.2 0 0 1 2.8 13v-1.7A1.2 1.2 0 0 1 4 10.1h.2a1 1 0 0 0 1-.7 1 1 0 0 0-.2-1.1l-.1-.1a1.2 1.2 0 0 1 0-1.7l1.2-1.2a1.2 1.2 0 0 1 1.7 0l.1.1a1 1 0 0 0 1.1.2 1 1 0 0 0 .6-.9V4.4A1.2 1.2 0 0 1 10.8 3h1.7a1.2 1.2 0 0 1 1.2 1.2v.2a1 1 0 0 0 .7 1 1 1 0 0 0 1.1-.2l.1-.1a1.2 1.2 0 0 1 1.7 0l1.2 1.2a1.2 1.2 0 0 1 0 1.7l-.1.1a1 1 0 0 0-.2 1.1 1 1 0 0 0 .9.6h.3a1.2 1.2 0 0 1 1.2 1.2V13a1.2 1.2 0 0 1-1.2 1.2h-.2a1 1 0 0 0-1 .8Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div class="board-mission-header__right">
        <div class="board-mission-indicator">
            <span class="board-mission-indicator__label">Save Status</span>
            <strong class="board-mission-indicator__value">Saved</strong>
        </div>

        <div class="board-mission-indicator">
            <span class="board-mission-indicator__label">Current Time</span>
            <strong class="board-mission-indicator__value" data-board-current-time>--:--</strong>
        </div>

        <div class="board-mission-indicator">
            <span class="board-mission-indicator__label">Agent Code</span>
            <strong class="board-mission-indicator__value">{{ $agentCode }}</strong>
        </div>
    </div>
</header>

<script>
(function () {
    const timeNode = document.querySelector('[data-board-current-time]');
    if (!timeNode) return;

    const renderTime = () => {
        const now = new Date();
        timeNode.textContent = now.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });
    };

    renderTime();
    window.setInterval(renderTime, 1000 * 30);
})();
</script>