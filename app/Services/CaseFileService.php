<?php

namespace App\Services;

use App\Models\CaseFile;
use App\Models\Player;
use Illuminate\Support\Collection;

class CaseFileService
{
    public function playerCase(
        Player $player,
        string $code
    )
    {
        return $player
            ->cases()
            ->where('code', $code)
            ->firstOrFail();
    }

    public function files(
        Player $player,
        string $code,
        ?string $search = null
    ): Collection {

        return $this
            ->playerCase($player, $code)
            ->files()
            ->when($search, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('title', 'like', '%'.$search.'%')
                        ->orWhere('description', 'like', '%'.$search.'%')
                        ->orWhere('section', 'like', '%'.$search.'%');
                });
            })
            ->orderBy('section')
            ->orderBy('display_order')
            ->orderBy('title')
            ->get();

    }

    public function groupedFiles(
        Player $player,
        string $code,
        ?string $search = null
    ): Collection {

        return $this
            ->files($player, $code, $search)
            ->groupBy('section');

    }

    public function contentStats(
        Player $player,
        string $code
    ): array {
        $files = $this->files($player, $code);

        return [

            'totalFiles' => $files->count(),

            'lockedFiles' => $files
                ->where('locked', true)
                ->count(),

            'unlockedFiles' => $files
                ->where('locked', false)
                ->count(),

            'totalSections' => $files
                ->pluck('section')
                ->filter()
                ->unique()
                ->count(),

            'lastUpdated' => $files
                ->sortByDesc('updated_at')
                ->first()
                ?->updated_at,

        ];
    }

    public function playerFile(
        Player $player,
        string $code,
        int $id
    ): CaseFile {

        return $this
            ->playerCase($player, $code)
            ->files()
            ->where('locked', false)
            ->findOrFail($id);

    }

    public function adjacentFiles(
        Player $player,
        string $code,
        int $id
    ): array {
        $files = $this
            ->files($player, $code)
            ->where('locked', false)
            ->values();

        $currentIndex = $files->search(function (CaseFile $file) use ($id) {
            return $file->id === $id;
        });

        return [
            'previous' => $currentIndex !== false ? $files->get($currentIndex - 1) : null,
            'next' => $currentIndex !== false ? $files->get($currentIndex + 1) : null,
        ];
    }
}