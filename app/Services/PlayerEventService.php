<?php

namespace App\Services;

use App\Models\InvestigationCase;
use App\Models\Player;

class PlayerEventService
{
    public function __construct(
        protected NotificationService $notificationService
    ) {
    }

    /**
     * Called whenever a mission is unlocked.
     */
    public function missionUnlocked(
        Player $player,
        InvestigationCase $case
    ): void {

        $this->notificationService->sendToPlayer(

            $player,

            'mission_unlocked',

            'Mission Unlocked',

            sprintf(
                '%s has been added to your account.',
                $case->title
            ),

            route('cases.show', $case->code),

            'folder',

            'green'
        );

        /*
        |------------------------------------------------------------
        | Future Packs
        |------------------------------------------------------------
        |
        | XP
        | Achievements
        | Activity Log
        | Rank System
        |
        */
    }

    /**
     * Investigation completed.
     */
    public function investigationCompleted(
        Player $player,
        InvestigationCase $case
    ): void {

        // Future Pack
    }

    /**
     * Rank Up.
     */
    public function rankUp(
        Player $player
    ): void {

        // Future Pack
    }

    /**
     * Achievement unlocked.
     */
    public function achievementUnlocked(
        Player $player,
        string $achievement
    ): void {

        // Future Pack
    }
}