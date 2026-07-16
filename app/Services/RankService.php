<?php

namespace App\Services;

use App\Models\Player;

class RankService
{
    /**
     * Default rank ladder.
     *
     * The array key represents the minimum XP required for the rank.
     * Keep this structure flexible so future ranks can be added
     * without changing the service architecture.
     *
     * @var array<int, string>
     */
    protected array $ranks = [
        0 => 'Recruit',
        1000 => 'Junior Agent',
        2500 => 'Field Agent',
        5000 => 'Senior Agent',
        8500 => 'Lead Investigator',
        13000 => 'Special Agent',
        19000 => 'Chief Investigator',
        26000 => 'Director Candidate',
    ];

    public function determineRank(int $xp): string
    {
        $xp = max(0, $xp);
        $rank = 'Recruit';

        foreach ($this->ranks as $requiredXp => $label) {
            if ($xp >= $requiredXp) {
                $rank = $label;
                continue;
            }

            break;
        }

        return $rank;
    }

    public function sync(Player $player): Player
    {
        $rank = $this->determineRank((int) $player->xp);

        if ((string) $player->rank !== $rank) {
            $player->forceFill([
                'rank' => $rank,
            ])->save();
        }

        return $player->refresh();
    }

    public function syncByXp(Player $player, int $xp): Player
    {
        $rank = $this->determineRank($xp);

        if ((string) $player->rank !== $rank) {
            $player->forceFill([
                'rank' => $rank,
            ])->save();
        }

        return $player->refresh();
    }

    public function all(): array
    {
        return $this->ranks;
    }
}