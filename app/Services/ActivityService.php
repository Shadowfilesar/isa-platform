<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Player;

class ActivityService
{
    public function record(

        Player $player,

        string $type,

        string $title,

        ?string $description = null,

        string $icon = 'activity'

    ): ActivityLog {

        return ActivityLog::create([

            'player_id' => $player->id,

            'type' => $type,

            'title' => $title,

            'description' => $description,

            'icon' => $icon,

        ]);
    }
}