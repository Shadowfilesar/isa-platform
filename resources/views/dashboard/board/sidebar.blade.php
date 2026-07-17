@php
    $typeOptions = $boardFiles
        ->map(function ($file) {
            return strtolower((string) ($file->file_type ?? 'unknown'));
        })
        ->filter()
        ->unique()
        ->sort()
        ->values();

    $selectedFileId = $selectedFileId ?? null;
@endphp

<aside class="board-sidebar board-sidebar--evidence" data-board-sidebar>
    <div class="board-sidebar-header">
        <div class="board-sidebar-kicker">Evidence Library</div>
        <div class="board-sidebar-heading-row">
            <div>
                <h3 class="board-sidebar-title">Evidence Browser</h3>
                <p class="board-sidebar-subtitle">Search, filter, and drag case evidence onto the board.</p>
            </div>

            <div class="board-sidebar-count-wrap">
                <span class="board-sidebar-count">{{ $boardFiles->count() }}</span>
            </div>
        </div>
    </div>

    <div class="board-sidebar-toolbar">
        <label class="board-library-search" aria-label="Search evidence library">
            <span class="board-library-search-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
                    <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="1.8"></circle>
                </svg>
            </span>
            <input
                type="search"
                class="board-library-search-input"
                placeholder="Search evidence code or title"
                data-board-library-search
            >
        </label>

        <label class="board-library-filter" aria-label="Filter evidence by type">
            <span class="board-library-filter-label">Type</span>
            <select class="board-library-filter-select" data-board-library-filter>
                <option value="all">All Types</option>
                @foreach($typeOptions as $typeOption)
                    <option value="{{ $typeOption }}">{{ strtoupper($typeOption) }}</option>
                @endforeach
            </select>
        </label>
    </div>

    <div class="board-sidebar-body">
        <div class="board-evidence-list" data-board-library-list>
            @forelse($boardFiles as $file)
                @php
                    $fileType = strtolower((string) ($file->file_type ?? 'unknown'));
                    $fileCode = $file->code
                        ?? $file->evidence_code
                        ?? ('EV-' . str_pad((string) $file->id, 4, '0', STR_PAD_LEFT));

                    $status = 'reviewed';
                    if ($file->locked) {
                        $status = 'locked';
                    } elseif (empty($file->file_path) && empty($file->file_url) && empty($file->path) && empty($file->url) && empty($file->thumbnail)) {
                        $status = 'missing';
                    } elseif ($loop->first) {
                        $status = 'new';
                    }

                    $previewUrl = $file->thumbnail
                        ?? $file->preview_url
                        ?? $file->thumbnail_url
                        ?? $file->cover_image
                        ?? $file->file_url
                        ?? $file->url
                        ?? $file->path
                        ?? null;

                    $typeBadge = strtoupper($fileType);
                    $statusLabel = ucfirst($status);
                    $statusClass = 'is-' . $status;

                    $title = $file->title ?? 'Untitled Evidence';
                    $description = $file->description ?? '';
                    $isSelected = (string) $selectedFileId === (string) $file->id;
                @endphp

                <article
                    class="board-evidence-card {{ $isSelected ? 'is-selected' : '' }} {{ $file->locked ? 'is-locked' : '' }}"
                    data-board-library-item
                    data-file-id="{{ $file->id }}"
                    data-file-type="{{ $fileType }}"
                    data-file-code="{{ $fileCode }}"
                    data-search-text="{{ strtolower($fileCode . ' ' . $title . ' ' . $typeBadge . ' ' . $description) }}"
                    draggable="{{ $file->locked ? 'false' : 'true' }}"
                >
                    <div
                        class="board-evidence-preview board-preview--{{ $fileType }}"
                        aria-hidden="true"
                    >
                        @if(in_array($fileType, ['image', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']))
                            @if($previewUrl)
                                <img src="{{ $previewUrl }}" alt="" class="board-evidence-thumb">
                            @else
                                <div class="board-preview-fallback board-preview-fallback--image">
                                    <span class="board-preview-icon">
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <rect x="3" y="5" width="18" height="14" rx="2.5" stroke="currentColor" stroke-width="1.6"></rect>
                                            <circle cx="9" cy="10" r="1.5" fill="currentColor"></circle>
                                            <path d="M6 16l4-4 3 3 2-2 3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                </div>
                            @endif
                        @elseif($fileType === 'pdf')
                            @if($previewUrl)
                                <div class="board-preview-pdf-page">
                                    <img src="{{ $previewUrl }}" alt="" class="board-evidence-thumb">
                                </div>
                            @else
                                <div class="board-preview-fallback board-preview-fallback--pdf">
                                    <span class="board-preview-doc-label">PDF</span>
                                    <span class="board-preview-icon">
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path d="M8 3h6l5 5v13H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"></path>
                                            <path d="M14 3v5h5" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"></path>
                                            <path d="M9 16h6M9 12h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"></path>
                                        </svg>
                                    </span>
                                </div>
                            @endif
                        @elseif(in_array($fileType, ['video', 'mp4', 'mov', 'avi', 'webm']))
                            @if($previewUrl)
                                <img src="{{ $previewUrl }}" alt="" class="board-evidence-thumb">
                            @else
                                <div class="board-preview-fallback board-preview-fallback--video">
                                    <span class="board-preview-icon">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M8 6.5v11l9-5.5-9-5.5Z"></path>
                                        </svg>
                                    </span>
                                </div>
                            @endif
                            <span class="board-preview-play-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8 6.5v11l9-5.5-9-5.5Z"></path>
                                </svg>
                            </span>
                        @elseif(in_array($fileType, ['audio', 'mp3', 'wav', 'ogg', 'm4a']))
                            <div class="board-preview-fallback board-preview-fallback--audio">
                                <span class="board-preview-waveform" aria-hidden="true">
                                    <span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
                                </span>
                            </div>
                        @else
                            <div class="board-preview-fallback board-preview-fallback--unknown">
                                <span class="board-preview-icon">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path d="M8 3h6l5 5v13H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"></path>
                                        <path d="M14 3v5h5" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"></path>
                                        <path d="M9 12h6M9 16h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"></path>
                                    </svg>
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="board-evidence-main">
                        <div class="board-evidence-topline">
                            <span class="board-evidence-code">{{ $fileCode }}</span>
                            <span class="board-evidence-status {{ $statusClass }}">{{ $statusLabel }}</span>
                        </div>

                        <h4 class="board-evidence-title">{{ $title }}</h4>

                        <div class="board-evidence-meta">
                            <span class="board-evidence-type-badge">{{ $typeBadge }}</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="board-evidence-empty" data-board-library-empty>
                    <div class="board-evidence-empty-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M4 7.5A2.5 2.5 0 0 1 6.5 5h3l1.2 1.5H17.5A2.5 2.5 0 0 1 20 9v8.5A2.5 2.5 0 0 1 17.5 20h-11A2.5 2.5 0 0 1 4 17.5v-10Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"></path>
                            <path d="M8.5 11.5h7M8.5 15h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"></path>
                        </svg>
                    </div>
                    <h4>No evidence available</h4>
                    <p>Evidence added to this case will appear here and remain ready for board placement.</p>
                </div>
            @endforelse

            <div class="board-evidence-empty is-filtered" data-board-library-empty-filtered hidden>
                <div class="board-evidence-empty-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="1.6"></circle>
                        <path d="M20 20l-4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"></path>
                    </svg>
                </div>
                <h4>No matching evidence</h4>
                <p>Try a different code, title, or file type filter.</p>
            </div>
        </div>
    </div>
</aside>

<script>
(function () {
    const sidebar = document.querySelector('[data-board-sidebar]');
    if (!sidebar) return;

    const searchInput = sidebar.querySelector('[data-board-library-search]');
    const filterSelect = sidebar.querySelector('[data-board-library-filter]');
    const items = Array.from(sidebar.querySelectorAll('[data-board-library-item]'));
    const emptyFiltered = sidebar.querySelector('[data-board-library-empty-filtered]');

    const applyFilters = () => {
        const searchTerm = (searchInput?.value || '').trim().toLowerCase();
        const filterValue = (filterSelect?.value || 'all').toLowerCase();

        let visibleCount = 0;

        items.forEach((item) => {
            const searchText = item.dataset.searchText || '';
            const fileType = (item.dataset.fileType || '').toLowerCase();

            const matchesSearch = !searchTerm || searchText.includes(searchTerm);
            const matchesType = filterValue === 'all' || fileType === filterValue;

            const visible = matchesSearch && matchesType;
            item.hidden = !visible;

            if (visible) visibleCount += 1;
        });

        if (emptyFiltered) {
            emptyFiltered.hidden = visibleCount !== 0;
        }
    };

    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }

    if (filterSelect) {
        filterSelect.addEventListener('change', applyFilters);
    }

    items.forEach((item) => {
        item.addEventListener('click', () => {
            items.forEach((card) => card.classList.remove('is-selected'));
            item.classList.add('is-selected');
        });
    });

    applyFilters();
})();
</script>