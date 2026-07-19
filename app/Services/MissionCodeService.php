<?php

namespace App\Services;

use App\Enums\CaseStatus;
use App\Models\MissionCode;
use App\Models\Player;
use Illuminate\Support\Facades\DB;

class MissionCodeService
{
    public function redeem(Player $player, string $code): bool
    {
        return DB::transaction(function () use ($player, $code) {

            $missionCode = MissionCode::query()
                ->where('activation_code', $code)
                ->lockForUpdate()
                ->first();

            if (!$missionCode) {
                return false;
            }

            if ($missionCode->used) {
                return false;
            }

            $player->cases()->syncWithoutDetaching([

                $missionCode->case_id => [

                    'status' => CaseStatus::Assigned->value,

                    'assigned_at' => now(),

                ],

            ]);

            $missionCode->update([

                'used' => true,

                'used_by' => $player->id,

                'activated_at' => now(),

            ]);

            return true;

        });
    }
}
