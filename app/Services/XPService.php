<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Player;
use App\Models\XPLog;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class XPService
{
    public function __construct(
        protected RankService $rankService
    ) {
    }

    public function award(Player $player, int $amount, string $reason, ?Admin $admin = null, ?string $details = null): XPLog
    {
        if ($amount < 1) {
            throw new InvalidArgumentException('XP amount must be at least 1.');
        }

        return DB::transaction(function () use ($player, $amount, $reason, $admin, $details) {
            $player = Player::query()->lockForUpdate()->findOrFail($player->id);

            $beforeXp = (int) $player->xp;
            $afterXp = $beforeXp + $amount;
            $afterLevel = $this->calculateLevel($afterXp);

            $player->forceFill([
                'xp' => $afterXp,
                'total_xp' => (int) $player->total_xp + $amount,
                'level' => $afterLevel,
            ])->save();

            $player = $this->rankService->syncByXp($player, $afterXp);

            return XPLog::query()->create([
                'player_id' => $player->id,
                'admin_id' => $admin?->id,
                'amount' => $amount,
                'type' => 'award',
                'reason' => $reason,
                'details' => $details,
                'balance_before' => $beforeXp,
                'balance_after' => $afterXp,
            ]);
        });
    }

    public function remove(Player $player, int $amount, string $reason, ?Admin $admin = null, ?string $details = null): XPLog
    {
        if ($amount < 1) {
            throw new InvalidArgumentException('XP amount must be at least 1.');
        }

        return DB::transaction(function () use ($player, $amount, $reason, $admin, $details) {
            $player = Player::query()->lockForUpdate()->findOrFail($player->id);

            $beforeXp = (int) $player->xp;
            $afterXp = max(0, $beforeXp - $amount);
            $afterLevel = $this->calculateLevel($afterXp);

            $player->forceFill([
                'xp' => $afterXp,
                'level' => $afterLevel,
            ])->save();

            $player = $this->rankService->syncByXp($player, $afterXp);

            return XPLog::query()->create([
                'player_id' => $player->id,
                'admin_id' => $admin?->id,
                'amount' => $amount,
                'type' => 'remove',
                'reason' => $reason,
                'details' => $details,
                'balance_before' => $beforeXp,
                'balance_after' => $afterXp,
            ]);
        });
    }

    public function calculateLevel(int $xp): int
    {
        $xp = max(0, $xp);

        return (int) floor($xp / 1000) + 1;
    }

    public function syncLevel(Player $player): Player
    {
        $player->forceFill([
            'level' => $this->calculateLevel((int) $player->xp),
        ])->save();

        return $player->refresh();
    }
}