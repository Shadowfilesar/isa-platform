@php
    $boardStats = $boardStats ?? [];
    $existingBoardItems = $existingBoardItems ?? collect();
@endphp

<aside class="board-inspector">
    <div class="board-inspector-scroll">
        <div class="board-card p-4 space-y-4">
            <div>
                <h3 class="board-section-title">Inspector</h3>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="rounded-xl border border-white/10 bg-white/5 p-3">
                    <div class="text-[11px] uppercase tracking-[0.08em] text-slate-400">Items</div>
                    <div class="mt-2 text-xl font-semibold text-white">{{ $existingBoardItems->count() }}</div>
                </div>

                <div class="rounded-xl border border-white/10 bg-white/5 p-3">
                    <div class="text-[11px] uppercase tracking-[0.08em] text-slate-400">Files</div>
                    <div class="mt-2 text-xl font-semibold text-white">{{ $boardStats['total'] ?? 0 }}</div>
                </div>
            </div>

            <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                <div class="text-[11px] uppercase tracking-[0.08em] text-slate-400">Selection</div>
                <div id="board-selection-meta" class="mt-2 text-sm text-slate-300">
                    No item selected.
                </div>
            </div>
        </div>
    </div>
</aside>