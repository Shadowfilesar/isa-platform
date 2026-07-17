<?php

namespace App\Services;

use App\Models\CaseFile;
use App\Models\InvestigationBoard;
use App\Models\InvestigationBoardConnection;
use App\Models\InvestigationBoardItem;
use App\Models\InvestigationCase;
use App\Models\Player;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use InvalidArgumentException;

class InvestigationBoardService
{
    private const DEFAULT_ITEM_SIZES = [
        'document' => [320.0000, 220.0000],
        'documents' => [320.0000, 220.0000],
        'image' => [320.0000, 240.0000],
        'images' => [320.0000, 240.0000],
        'photo' => [320.0000, 240.0000],
        'photos' => [320.0000, 240.0000],
        'video' => [360.0000, 240.0000],
        'videos' => [360.0000, 240.0000],
        'audio' => [320.0000, 180.0000],
        'default' => [320.0000, 220.0000],
    ];

    private const CONFIDENCE_LEVELS = [
        'LOW',
        'MEDIUM',
        'HIGH',
    ];

    private const CONFIDENCE_STYLES = [
        'LOW' => [
            'badge' => 'border-slate-700 bg-slate-950/70 text-slate-300',
            'line' => 'bg-slate-600',
            'dot' => 'bg-slate-400',
        ],
        'MEDIUM' => [
            'badge' => 'border-amber-700/50 bg-amber-950/40 text-amber-300',
            'line' => 'bg-amber-500/80',
            'dot' => 'bg-amber-400',
        ],
        'HIGH' => [
            'badge' => 'border-red-700/50 bg-red-950/40 text-red-300',
            'line' => 'bg-red-500/80',
            'dot' => 'bg-red-400',
        ],
    ];

    public function getBoard(Player $player, InvestigationCase $case): InvestigationBoard
    {
        $board = InvestigationBoard::query()->firstOrCreate(
            [
                'player_id' => $player->id,
                'case_id' => $case->id,
                'is_default' => true,
            ],
            [
                'name' => 'Primary Board',
                'board_type' => 'default',
            ]
        );

        return $board->load([
            'items',
            'items.caseFile',
            'connections',
            'connections.sourceItem',
            'connections.targetItem',
        ]);
    }

    public function getItems(InvestigationBoard $board): Collection
    {
        return $board->items()
            ->with('caseFile')
            ->get();
    }

    public function getConnections(InvestigationBoard $board): Collection
    {
        return $board->connections()
            ->with(['sourceItem', 'targetItem'])
            ->get();
    }

    public function pinEvidence(InvestigationBoard $board, CaseFile $file): InvestigationBoardItem
    {
        return DB::transaction(function () use ($board, $file): InvestigationBoardItem {
            $existingItem = $board->items()
                ->where('case_file_id', $file->id)
                ->first();

            if ($existingItem instanceof InvestigationBoardItem) {
                return $existingItem->load(['board', 'caseFile']);
            }

            [$width, $height] = $this->defaultSizeForFile($file);

            $item = new InvestigationBoardItem([
                'case_file_id' => $file->id,
                'is_pinned' => true,
                'position_x' => $this->defaultPositionX($board),
                'position_y' => $this->defaultPositionY($board),
                'width' => $width,
                'height' => $height,
                'z_index' => $this->nextZIndex($board),
                'rotation' => 0,
                'pinned_at' => now(),
            ]);

            $board->items()->save($item);
            $this->autosave($board);

            return $item->fresh(['board', 'caseFile']);
        });
    }

    public function unpinEvidence(InvestigationBoard $board, CaseFile $file): void
    {
        DB::transaction(function () use ($board, $file): void {
            $board->items()
                ->where('case_file_id', $file->id)
                ->delete();

            $this->autosave($board);
        });
    }

    public function moveItem(InvestigationBoardItem $item, float $x, float $y): InvestigationBoardItem
    {
        $item->update([
            'position_x' => $x,
            'position_y' => $y,
            'last_moved_at' => now(),
        ]);

        $board = $item->board()->first();

        if ($board instanceof InvestigationBoard) {
            $this->autosave($board);
        }

        return $item->fresh(['board', 'caseFile']);
    }

    public function resizeItem(
        InvestigationBoardItem $item,
        ?float $width,
        ?float $height
    ): InvestigationBoardItem {
        $payload = [];

        if ($width !== null) {
            $payload['width'] = $width;
        }

        if ($height !== null) {
            $payload['height'] = $height;
        }

        if ($payload !== []) {
            $item->update($payload);
        }

        $board = $item->board()->first();

        if ($board instanceof InvestigationBoard) {
            $this->autosave($board);
        }

        return $item->fresh(['board', 'caseFile']);
    }

    public function bringToFront(InvestigationBoardItem $item): InvestigationBoardItem
    {
        return DB::transaction(function () use ($item): InvestigationBoardItem {
            $board = $item->board()->firstOrFail();

            $item->update([
                'z_index' => $this->nextZIndex($board),
            ]);

            $this->autosave($board);

            return $item->fresh(['board', 'caseFile']);
        });
    }

    public function createConnection(
        InvestigationBoard $board,
        InvestigationBoardItem $sourceItem,
        InvestigationBoardItem $targetItem,
        ?string $reason,
        string $confidenceLevel
    ): InvestigationBoardConnection {
        $normalizedConfidenceLevel = strtoupper($confidenceLevel);

        $this->assertValidConnection($board, $sourceItem, $targetItem, $normalizedConfidenceLevel);

        return DB::transaction(function () use (
            $board,
            $sourceItem,
            $targetItem,
            $reason,
            $normalizedConfidenceLevel
        ): InvestigationBoardConnection {
            $connection = $board->connections()
                ->where('source_board_item_id', $sourceItem->id)
                ->where('target_board_item_id', $targetItem->id)
                ->first();

            if ($connection instanceof InvestigationBoardConnection) {
                return $connection->load(['sourceItem', 'targetItem']);
            }

            $connection = new InvestigationBoardConnection([
                'source_board_item_id' => $sourceItem->id,
                'target_board_item_id' => $targetItem->id,
                'reason' => $reason,
                'confidence_level' => $normalizedConfidenceLevel,
            ]);

            $board->connections()->save($connection);

            $this->autosave($board);

            return $connection->fresh(['sourceItem', 'targetItem']);
        });
    }

    public function deleteConnection(
        InvestigationBoard $board,
        InvestigationBoardConnection $connection
    ): void {
        if ((int) $connection->investigation_board_id !== (int) $board->id) {
            throw new InvalidArgumentException('The connection does not belong to the provided board.');
        }

        DB::transaction(function () use ($board, $connection): void {
            $connection->delete();
            $this->autosave($board);
        });
    }

    public function autosave(InvestigationBoard $board): InvestigationBoard
    {
        $board->update([
            'last_saved_at' => now(),
        ]);

        return $board->fresh([
            'items',
            'items.caseFile',
            'connections',
            'connections.sourceItem',
            'connections.targetItem',
        ]);
    }

    public function buildBoardWorkspaceViewData(
        Player $player,
        InvestigationCase $case,
        string $section
    ): array {
        $defaultViewData = [
            'board' => null,
            'existingBoard' => null,
            'boardFiles' => collect(),
            'boardPreviewFiles' => collect(),
            'boardSections' => collect(),
            'pinnedBoardFiles' => collect(),
            'sidebarBoardFiles' => collect(),
            'boardStats' => [
                'total' => 0,
                'locked' => 0,
                'available' => 0,
                'sections' => 0,
                'pinned' => 0,
                'remaining' => 0,
            ],
            'pinnedPreviewCards' => collect(),
            'visibleBoardConnections' => collect(),
            'connectionSummary' => [
                'total' => 0,
                'visible' => 0,
                'high' => 0,
                'medium' => 0,
                'low' => 0,
            ],
            'existingBoardItems' => collect(),
            'boardConnections' => collect(),
            'boardAtmospherics' => collect(),
            'boardNotes' => collect(),
            'evidenceFiles' => collect(),
        ];

        if ($section !== 'Board') {
            return $defaultViewData;
        }

        $board = $this->getBoard($player, $case);

        $boardFiles = $case->files()
            ->orderBy('section')
            ->orderBy('display_order')
            ->orderBy('id')
            ->get()
            ->values();

        $existingBoardItems = $board->items instanceof Collection
            ? $board->items->keyBy('case_file_id')
            : collect();

        $boardConnections = $board->connections instanceof Collection
            ? $board->connections->values()
            : collect();

        $boardSections = $boardFiles->pluck('section')
            ->map(fn ($value) => $value ?: 'Evidence')
            ->filter()
            ->unique()
            ->values();

        $boardPreviewFiles = $boardFiles
            ->filter(fn (CaseFile $file) => ! $file->locked)
            ->map(function (CaseFile $file) use ($case, $existingBoardItems) {
                $boardItem = $existingBoardItems->get($file->id);

                return [
                    'file_id' => $file->id,
                    'title' => $file->title,
                    'description' => $file->description,
                    'url' => route('case-files.show', ['case' => $case, 'file' => $file->id]),
                    'pin_url' => route('investigation-board.pin', ['case' => $case,'file' => $file->id,]),
                    'preview_html' => $this->buildPreviewHtml($file, $boardItem),
                    'category' => $file->category,
                    'type' => $file->file_type,
                    'section' => $file->section ?: 'Evidence',
                    'locked' => (bool) $file->locked,
                    'z_index' => $boardItem?->z_index ?? 0,
                    'board_item_id' => $boardItem?->id,
                    'is_pinned' => $boardItem instanceof InvestigationBoardItem,
                    'position_x' => $boardItem?->position_x,
                    'position_y' => $boardItem?->position_y,
                    'width' => $boardItem?->width,
                    'height' => $boardItem?->height,
                    'rotation' => $boardItem?->rotation,
                    'last_moved_at' => $boardItem?->last_moved_at,
                    'pinned_at' => $boardItem?->pinned_at,
                ];
            })
            ->values();

        $pinnedBoardFiles = $boardFiles
            ->filter(fn (CaseFile $file) => $existingBoardItems->has($file->id))
            ->values();

        $sidebarBoardFiles = $boardFiles
            ->filter(function (CaseFile $file) use ($existingBoardItems) {
                return ! $existingBoardItems->has($file->id);
            })
            ->values();

        $boardStats = [
            'total' => $boardFiles->count(),
            'locked' => $boardFiles->where('locked', true)->count(),
            'available' => $boardFiles->where('locked', false)->count(),
            'sections' => $boardSections->count(),
            'pinned' => $existingBoardItems->count(),
            'remaining' => $sidebarBoardFiles->count(),
        ];

        $visiblePinnedItemIds = $existingBoardItems
            ->pluck('id')
            ->filter()
            ->values();

        $visibleBoardConnections = $boardConnections
            ->filter(function ($connection) use ($visiblePinnedItemIds) {
                return $visiblePinnedItemIds->contains($connection->source_board_item_id)
                    && $visiblePinnedItemIds->contains($connection->target_board_item_id);
            })
            ->map(function ($connection) {
                $confidence = strtoupper((string) $connection->confidence_level);
                $style = self::CONFIDENCE_STYLES[$confidence] ?? self::CONFIDENCE_STYLES['LOW'];

                return [
                    'id' => $connection->id,
                    'reason' => $connection->reason,
                    'confidence_level' => $confidence,
                    'created_at' => $connection->created_at,
                    'source_board_item_id' => $connection->source_board_item_id,
                    'target_board_item_id' => $connection->target_board_item_id,
                    'source_title' => $connection->sourceItem?->caseFile?->title
                        ?? $connection->sourceItem?->caseFile?->filename
                        ?? 'Unknown Source',
                    'target_title' => $connection->targetItem?->caseFile?->title
                        ?? $connection->targetItem?->caseFile?->filename
                        ?? 'Unknown Target',
                    'style' => $style,
                ];
            })
            ->values();

        $connectionLevels = $boardConnections->map(function ($connection) {
            return strtoupper((string) $connection->confidence_level);
        });

        $connectionSummary = [
            'total' => $boardConnections->count(),
            'visible' => $visibleBoardConnections->count(),
            'high' => $connectionLevels->filter(fn ($value) => $value === 'HIGH')->count(),
            'medium' => $connectionLevels->filter(fn ($value) => $value === 'MEDIUM')->count(),
            'low' => $connectionLevels->filter(fn ($value) => $value === 'LOW')->count(),
        ];

        $boardNotes = collect([
            [
                'title' => 'Evidence Locker',
                'body' => 'Drag the unlocked files directly onto the board. Pinned files keep their saved positions, rotation, size, and connections.',
            ],
            [
                'title' => 'Board Persistence',
                'body' => 'Existing pinned evidence is restored from the saved board for the current player and case.',
            ],
        ]);

        $boardAtmospherics = collect([
            [
                'label' => 'Canvas Profile',
                'value' => 'Immersive Detective Layout',
            ],
            [
                'label' => 'Card Sizing',
                'value' => 'Mixed Evidence Geometry',
            ],
            [
                'label' => 'Viewer Access',
                'value' => 'Existing File Flow',
            ],
            [
                'label' => 'Workspace State',
                'value' => $board->last_saved_at ? 'Autosave Online' : 'Ready',
            ],
        ]);

        return array_merge($defaultViewData, [
            'board' => $board,
            'existingBoard' => $board,
            'boardFiles' => $boardFiles,
            'boardPreviewFiles' => $boardPreviewFiles,
            'boardSections' => $boardSections,
            'pinnedBoardFiles' => $pinnedBoardFiles,
            'sidebarBoardFiles' => $sidebarBoardFiles,
            'boardStats' => $boardStats,
            'pinnedPreviewCards' => $boardPreviewFiles->where('is_pinned', true)->values(),
            'visibleBoardConnections' => $visibleBoardConnections,
            'connectionSummary' => $connectionSummary,
            'existingBoardItems' => $existingBoardItems,
            'boardConnections' => $boardConnections,
            'boardAtmospherics' => $boardAtmospherics,
            'boardNotes' => $boardNotes,
            'evidenceFiles' => $boardFiles->filter(function (CaseFile $file) {
                return ($file->section ?: 'Evidence') === 'Evidence';
            })->values(),
        ]);
    }

    private function buildPreviewHtml(CaseFile $file, ?InvestigationBoardItem $boardItem = null): HtmlString
    {
        $title = e($file->title);
        $description = e((string) ($file->description ?: 'No description available.'));
        $section = e($file->section ?: 'Evidence');
        $category = e((string) ($file->category ?: 'file'));
        $type = e(strtoupper((string) ($file->file_type ?: $file->category ?: 'FILE')));
        $statusLabel = $file->locked ? 'Locked' : 'Available';
        $statusClasses = $file->locked
            ? 'border-red-900 bg-red-950/60 text-red-300'
            : 'border-emerald-900 bg-emerald-950/60 text-emerald-300';
        $pinnedBadge = $boardItem instanceof InvestigationBoardItem
            ? '<span class="rounded-full border border-amber-900 bg-amber-950/60 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-amber-300">Pinned</span>'
            : '';

        $html = <<<HTML
<div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-4 transition hover:border-amber-500/60 hover:bg-slate-900">
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <div class="text-[11px] uppercase tracking-[0.22em] text-slate-500">{$section}</div>
            <div class="mt-2 truncate text-sm font-semibold text-white">{$title}</div>
        </div>
        <div class="flex items-center gap-2">
            {$pinnedBadge}
            <span class="rounded-full border {$statusClasses} px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide">{$statusLabel}</span>
        </div>
    </div>
    <div class="mt-4 rounded-xl border border-slate-800 bg-slate-950/80 px-3 py-2 text-[11px] uppercase tracking-[0.18em] text-slate-500">
        {$type} · {$category}
    </div>
    <p class="mt-4 line-clamp-3 text-sm leading-6 text-slate-400">{$description}</p>
</div>
HTML;

        return new HtmlString($html);
    }

    private function nextZIndex(InvestigationBoard $board): int
    {
        return ((int) $board->items()->max('z_index')) + 1;
    }

    private function defaultPositionX(InvestigationBoard $board): float
    {
        $count = (int) $board->items()->count();

        return 80 + (($count % 4) * 36);
    }

    private function defaultPositionY(InvestigationBoard $board): float
    {
        $count = (int) $board->items()->count();

        return 80 + (intdiv($count, 4) * 36);
    }

    private function defaultSizeForFile(CaseFile $file): array
    {
        return self::DEFAULT_ITEM_SIZES[$file->category]
            ?? self::DEFAULT_ITEM_SIZES['default'];
    }

    private function assertValidConnection(
        InvestigationBoard $board,
        InvestigationBoardItem $sourceItem,
        InvestigationBoardItem $targetItem,
        string $confidenceLevel
    ): void {
        if ((int) $sourceItem->investigation_board_id !== (int) $board->id) {
            throw new InvalidArgumentException('The source item does not belong to the provided board.');
        }

        if ((int) $targetItem->investigation_board_id !== (int) $board->id) {
            throw new InvalidArgumentException('The target item does not belong to the provided board.');
        }

        if ((int) $sourceItem->id === (int) $targetItem->id) {
            throw new InvalidArgumentException('A board item cannot connect to itself.');
        }

        if (! in_array($confidenceLevel, self::CONFIDENCE_LEVELS, true)) {
            throw new InvalidArgumentException('The confidence level is invalid.');
        }
    }
}