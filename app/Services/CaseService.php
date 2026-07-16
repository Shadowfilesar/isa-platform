<?php

namespace App\Services;

use App\Models\InvestigationCase;
use App\Models\Player;
use Illuminate\Database\Eloquent\Collection;

class CaseService
{
    public function __construct(
        private readonly CaseWorkspaceViewService $caseWorkspaceViewService
    ) {
    }

    public function getPlayerCases(Player $player): Collection
    {
        return $player->cases()
            ->withCount('files')
            ->latest()
            ->get();
    }

    public function getCaseForPlayer(
        Player $player,
        InvestigationCase $case
    ): InvestigationCase {
        abort_unless(
            $player->cases()->where('cases.id', $case->id)->exists(),
            404
        );

        return $case->load([
            'files' => function ($query) {
                $query->orderBy('section')
                    ->orderBy('display_order');
            },
        ]);
    }

    public function buildCaseWorkspaceData(
        InvestigationCase $case,
        string $section
    ): array {
        return $this->caseWorkspaceViewService->build($case, $section);
    }
}