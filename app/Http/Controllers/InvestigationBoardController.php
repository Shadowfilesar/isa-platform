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
        $board = $this->getBoard($player, $case);
        $boardItems = $board->items instanceof Collection
            ? $board->items->values()
            : collect();
        $boardConnections = $board->connections instanceof Collection
            ? $board->connections->values()
            : collect();

        $boardFiles = $case->files()
            ->orderBy('section')
            ->orderBy('display_order')
            ->orderBy('id')
            ->get()
            ->values();

        $boardSections = $boardFiles->pluck('section')
            ->map(fn ($value) => $value ?: 'Evidence')
            ->filter()
            ->unique()
            ->values();

        $existingBoardItems = $boardItems->keyBy('case_file_id');
        $boardItemIds = $boardItems->pluck('id')->filter()->values();

        $visibleBoardConnections = $boardConnections
            ->filter(function ($connection) use ($boardItemIds) {
                return $boardItemIds->contains($connection->source_board_item_id)
                    && $boardItemIds->contains($connection->target_board_item_id);
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

        $pinnedEvidence = $boardFiles
            ->filter(function ($file) use ($existingBoardItems) {
                return $existingBoardItems->has($file->id);
            })
            ->map(function ($file) use ($existingBoardItems) {
                return [
                    'file' => $file,
                    'board_item' => $existingBoardItems->get($file->id),
                ];
            })
            ->values();

        $unpinnedEvidence = $boardFiles
            ->filter(function ($file) use ($existingBoardItems) {
                return ! $existingBoardItems->has($file->id);
            })
            ->values();

        $boardPreviewFiles = $pinnedEvidence->take(6)->values();
        $pinnedBoardFiles = $boardPreviewFiles->pluck('file')->values();
        $sidebarBoardFiles = $unpinnedEvidence->values();

        $boardStats = [
            'total' => $boardFiles->count(),
            'locked' => $boardFiles->where('locked', true)->count(),
            'available' => $boardFiles->where('locked', false)->count(),
            'sections' => $boardSections->count(),
            'pinned' => $boardItems->count(),
            'remaining' => $sidebarBoardFiles->count(),
        ];

        $confidenceCounts = $boardConnections->map(function ($connection) {
            return strtoupper((string) $connection->confidence_level);
        });

        $connectionSummary = [
            'total' => $boardConnections->count(),
            'visible' => $visibleBoardConnections->count(),
            'high' => $confidenceCounts->filter(fn ($value) => $value === 'HIGH')->count(),
            'medium' => $confidenceCounts->filter(fn ($value) => $value === 'MEDIUM')->count(),
            'low' => $confidenceCounts->filter(fn ($value) => $value === 'LOW')->count(),
        ];

        $boardNotes = collect([
            [
                'id' => 'workspace-guidance',
                'title' => 'Evidence Locker',
                'content' => 'Drag the unlocked files directly onto the board. Pinned files keep their saved positions, rotation, size, and connections.',
            ],
        ]);

        $boardAtmospherics = collect([
            [
                'id' => 'layout-profile',
                'label' => 'Canvas Profile',
                'value' => 'Immersive Detective Layout',
                'description' => 'Large screens present evidence as a free-form investigation wall.',
            ],
            [
                'id' => 'card-sizing',
                'label' => 'Card Sizing',
                'value' => 'Saved Evidence Geometry',
                'description' => 'Pinned evidence preserves stored width, height, z-index, and placement.',
            ],
            [
                'id' => 'connection-state',
                'label' => 'Connections',
                'value' => $connectionSummary['total'] > 0 ? 'Linked Evidence Active' : 'Ready For Correlation',
                'description' => 'Visible relationships render from saved board connections.',
            ],
            [
                'id' => 'workspace-state',
                'label' => 'Workspace State',
                'value' => $board->last_saved_at ? 'Autosave Online' : 'Unsaved Session',
                'description' => 'Board state is tied to the current player and active case.',
            ],
        ]);

        return [
            'board' => $board,
            'existingBoard' => $board,
            'boardFiles' => $boardFiles,
            'boardPreviewFiles' => $boardPreviewFiles,
            'boardSections' => $boardSections,
            'pinnedBoardFiles' => $pinnedBoardFiles,
            'sidebarBoardFiles' => $sidebarBoardFiles,
            'boardStats' => $boardStats,
            'pinnedPreviewCards' => $boardPreviewFiles,
            'pinnedEvidence' => $pinnedEvidence,
            'existingBoardItems' => $existingBoardItems,
            'boardConnections' => $boardConnections,
            'visibleBoardConnections' => $visibleBoardConnections,
            'connectionSummary' => $connectionSummary,
            'boardNotes' => $boardNotes,
            'boardAtmospherics' => $boardAtmospherics,
            'workspaceState' => [
                'section' => $section,
                'is_board_section' => $section === 'Board',
                'has_board_items' => $boardItems->isNotEmpty(),
                'has_connections' => $boardConnections->isNotEmpty(),
                'has_unpinned_files' => $sidebarBoardFiles->isNotEmpty(),
                'player_id' => $player->id,
                'case_id' => $case->id,
                'board_id' => $board->id,
                'last_saved_at' => $board->last_saved_at,
            ],
        ];
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