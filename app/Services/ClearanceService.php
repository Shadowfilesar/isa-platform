<?php

namespace App\Services;

use App\Models\Player;
use InvalidArgumentException;

class ClearanceService
{
    /**
     * Ordered clearance ladder.
     *
     * The numeric value represents authority weight for comparisons.
     * Keep this structure flexible so new levels can be added later
     * without changing the service architecture.
     *
     * @var array<string, int>
     */
    protected array $levels = [
        'Level 1' => 1,
        'Level 2' => 2,
        'Level 3' => 3,
        'Level 4' => 4,
        'Director' => 5,
    ];

    public function all(): array
    {
        return array_keys($this->levels);
    }

    public function normalize(?string $clearance): ?string
    {
        if ($clearance === null) {
            return null;
        }

        $clearance = trim($clearance);

        if ($clearance === '') {
            return null;
        }

        foreach ($this->levels as $label => $weight) {
            if (strcasecmp($label, $clearance) === 0) {
                return $label;
            }
        }

        throw new InvalidArgumentException('Invalid clearance level.');
    }

    public function compare(?string $playerClearance, ?string $requiredClearance): int
    {
        $player = $this->weight($playerClearance);
        $required = $this->weight($requiredClearance);

        return $player <=> $required;
    }

    public function canAccess(Player $player, ?string $requiredClearance): bool
    {
        return $this->compare($player->clearance_level, $requiredClearance) >= 0;
    }

    public function update(Player $player, ?string $clearance): Player
    {
        $normalized = $this->normalize($clearance);

        $player->forceFill([
            'clearance_level' => $normalized,
        ])->save();

        return $player->refresh();
    }

    protected function weight(?string $clearance): int
    {
        if ($clearance === null || trim($clearance) === '') {
            return 0;
        }

        $normalized = $this->normalize($clearance);

        return $this->levels[$normalized];
    }
}