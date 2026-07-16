<?php

namespace App\Services;

use App\Models\Player;

class PlayerService
{
    /**
     * اللاعب الحالي.
     */
    public function current(int $playerId): Player
    {
        return Player::findOrFail($playerId);
    }

    /**
     * بيانات لوحة التحكم.
     */
    public function dashboard(Player $player): array
    {
        $activeCases = $player->cases()
            ->where('published', true)
            ->orderBy('created_at')
            ->get();

        return [

            'player' => $player,

            'activeCases' => $activeCases,

            'lastLogin' => $player->last_login,

            'statistics' => [

                'totalCases' => $activeCases->count(),

                'completedCases' => 0,

                'activeCases' => $activeCases->count(),

            ],

        ];
    }

    /**
     * تحديث آخر دخول.
     */
    public function updateLastLogin(Player $player): void
    {
        $player->update([
            'last_login' => now(),
        ]);
    }
}