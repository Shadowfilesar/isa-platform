<?php

namespace App\Services;

use App\Models\InvestigationBoard;
use App\Models\InvestigationCase;
use App\Models\Player;
use Illuminate\Support\Collection;

class InvestigationBoardViewService
{
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

    public function build(
        Player $player,
        InvestigationCase $case,
        string $section
    ): array {
        $defaultViewData = [
            'boardFiles' => collect(),
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
            'existingBoard' => null,
        ];

        if ($section !== 'Board') {
            return $defaultViewData;
        }

        $boardFiles = $case->files
            ->sortBy([
                ['section', 'asc'],
                ['display_order', 'asc'],
            ])
            ->values();

        $boardSections = $this->buildBoardSections($boardFiles);
        $pinnedBoardFiles = $boardFiles->take(6)->values();
        $sidebarBoardFiles = $boardFiles->slice($pinnedBoardFiles->count())->values();
        $boardStats = $this->buildBoardStats(
            $boardFiles,
            $boardSections,
            $pinnedBoardFiles,
            $sidebarBoardFiles
        );

        $existingBoard = $this->loadExistingBoard($player, $case);
        $pinnedPreviewCards = $this->buildPinnedPreviewCards($pinnedBoardFiles, $existingBoard);
        $visibleBoardConnections = $this->buildVisibleBoardConnections($existingBoard, $pinnedPreviewCards);
        $connectionSummary = $this->buildConnectionSummary($existingBoard, $visibleBoardConnections);

        return [
            'boardFiles' => $boardFiles,
            'boardSections' => $boardSections,
            'pinnedBoardFiles' => $pinnedBoardFiles,
            'sidebarBoardFiles' => $sidebarBoardFiles,
            'boardStats' => $boardStats,
            'pinnedPreviewCards' => $pinnedPreviewCards,
            'visibleBoardConnections' => $visibleBoardConnections,
            'connectionSummary' => $connectionSummary,
            'existingBoard' => $existingBoard,
        ];
    }

    private function loadExistingBoard(
        Player $player,
        InvestigationCase $case
    ): ?InvestigationBoard {
        return InvestigationBoard::query()
            ->where('player_id', $player->id)
            ->where('case_id', $case->id)
            ->where('is_default', true)
            ->with([
                'items.caseFile',
                'connections.sourceItem.caseFile',
                'connections.targetItem.caseFile',
            ])
            ->first();
    }

    private function buildBoardSections(Collection $boardFiles): Collection
    {
        return $boardFiles->pluck('section')
            ->filter()
            ->unique()
            ->values();
    }

    private function buildBoardStats(
        Collection $boardFiles,
        Collection $boardSections,
        Collection $pinnedBoardFiles,
        Collection $sidebarBoardFiles
    ): array {
        return [
            'total' => $boardFiles->count(),
            'locked' => $boardFiles->where('locked', true)->count(),
            'available' => $boardFiles->where('locked', false)->count(),
            'sections' => $boardSections->count(),
            'pinned' => $pinnedBoardFiles->count(),
            'remaining' => $sidebarBoardFiles->count(),
        ];
    }

    private function buildPinnedPreviewCards(
        Collection $pinnedBoardFiles,
        ?InvestigationBoard $existingBoard
    ): Collection {
        $pinnedBoardItems = $existingBoard?->items ?? collect();
        $pinnedBoardItemMap = $pinnedBoardItems->keyBy('case_file_id');

        return $pinnedBoardFiles->map(function ($file) use ($pinnedBoardItemMap) {
            return [
                'file' => $file,
                'board_item' => $pinnedBoardItemMap->get($file->id),
            ];
        })->values();
    }

    private function buildVisibleBoardConnections(
        ?InvestigationBoard $existingBoard,
        Collection $pinnedPreviewCards
    ): Collection {
        $boardConnections = $existingBoard?->connections ?? collect();

        $visiblePinnedItemIds = $pinnedPreviewCards
            ->pluck('board_item')
            ->filter()
            ->pluck('id')
            ->values();

        return $boardConnections
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
                    'source_title' => $connection->sourceItem?->caseFile?->title ?? 'Unknown Source',
                    'target_title' => $connection->targetItem?->caseFile?->title ?? 'Unknown Target',
                    'style' => $style,
                ];
            })
            ->values();
    }

    private function buildConnectionSummary(
        ?InvestigationBoard $existingBoard,
        Collection $visibleBoardConnections
    ): array {
        $boardConnections = $existingBoard?->connections ?? collect();

        return [
            'total' => $boardConnections->count(),
            'visible' => $visibleBoardConnections->count(),
            'high' => $boardConnections->where('confidence_level', 'HIGH')->count(),
            'medium' => $boardConnections->where('confidence_level', 'MEDIUM')->count(),
            'low' => $boardConnections->where('confidence_level', 'LOW')->count(),
        ];
    }
}