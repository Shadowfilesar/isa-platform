<?php

namespace App\Services;

use App\Models\InvestigationCase;
use App\Models\Player;

class CaseService
{
    /**
     * جميع قضايا اللاعب
     */
    public function playerCases(Player $player)
    {
        return $player->cases()

            ->where('published', true)

            ->orderBy('title')

            ->get();
    }

    /**
     * قضية واحدة
     */
    public function playerCase(
        Player $player,
        string $code
    ): InvestigationCase {

        return $player->cases()

            ->where('code', $code)

            ->where('published', true)

            ->firstOrFail();

    }

    /**
     * ملفات القضية
     */
    public function files(
        InvestigationCase $case
    ) {

        return $case->files()

            ->where('published', true)

            ->orderBy('sort_order')

            ->get();

    }
}