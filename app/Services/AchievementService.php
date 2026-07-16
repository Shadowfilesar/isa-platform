<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\Player;
use App\Models\PlayerAchievement;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AchievementService
{
    public function __construct(
        protected XPService $xpService
    ) {
    }

    public function award(Player $player, string $slug, ?CarbonInterface $earnedAt = null): ?PlayerAchievement
    {
        $achievement = Achievement::query()->where('slug', $slug)->first();

        if (! $achievement) {
            return null;
        }

        return DB::transaction(function () use ($player, $achievement, $earnedAt) {
            $existing = PlayerAchievement::query()
                ->where('player_id', $player->id)
                ->where('achievement_id', $achievement->id)
                ->first();

            if ($existing) {
                return $existing;
            }

            $playerAchievement = PlayerAchievement::query()->create([
                'player_id' => $player->id,
                'achievement_id' => $achievement->id,
                'earned_at' => $earnedAt ?? now(),
            ]);

            if ((int) $achievement->xp_reward > 0) {
                $this->xpService->award(
                    $player,
                    (int) $achievement->xp_reward,
                    'achievement',
                    null,
                    'Achievement unlocked: '.$achievement->name
                );
            }

            return $playerAchievement;
        });
    }

    public function has(Player $player, string $slug): bool
    {
        return PlayerAchievement::query()
            ->where('player_id', $player->id)
            ->whereHas('achievement', fn ($query) => $query->where('slug', $slug))
            ->exists();
    }

    public function playerAchievements(Player $player): Collection
    {
        return PlayerAchievement::query()
            ->with('achievement')
            ->where('player_id', $player->id)
            ->latest('earned_at')
            ->get();
    }

    public function availableAchievements(): Collection
    {
        return Achievement::query()
            ->orderBy('id')
            ->get();
    }

    public function check(Player $player): void
    {
        if ($player->last_login !== null) {
            $this->award($player, 'first-login');
        }

        if ($player->cases()->exists()) {
            $this->award($player, 'first-case-assigned');
        }

        if ((int) $player->xp >= 100) {
            $this->award($player, 'first-100-xp');
        }

        if ((int) $player->level >= 5) {
            $this->award($player, 'reach-level-5');
        }

        if ((int) $player->level >= 10) {
            $this->award($player, 'reach-level-10');
        }

        if (in_array($player->clearance_level, ['Level 2', 'Level 3', 'Level 4', 'Director'], true)) {
            $this->award($player, 'reach-clearance-level-2');
        }

        if (in_array($player->clearance_level, ['Level 3', 'Level 4', 'Director'], true)) {
            $this->award($player, 'reach-clearance-level-3');
        }
    }
}