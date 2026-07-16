<?php

namespace App\Services;

use App\Models\InvestigationCase;
use Illuminate\Database\Eloquent\Collection;

class CaseWorkspaceViewService
{
    public function build(InvestigationCase $case, string $section): array
    {
        $files = $this->resolveSectionFiles($case, $section);
        $stats = $this->buildStats($case);
        $progress = $this->buildProgress($stats);

        return [
            'files' => $files,
            'stats' => $stats,
            'progress' => $progress,
        ];
    }

    private function resolveSectionFiles(
        InvestigationCase $case,
        string $section
    ): Collection {
        if ($section === 'Overview' || $section === 'Board') {
            return $case->files;
        }

        return $case->files
            ->where('section', $section)
            ->values();
    }

    private function buildStats(InvestigationCase $case): array
    {
        return [
            'totalFiles' => $case->files->count(),
            'lockedFiles' => $case->files->where('locked', true)->count(),
            'unlockedFiles' => $case->files->where('locked', false)->count(),
            'totalSections' => $case->files->pluck('section')->filter()->unique()->count(),
            'lastUpdated' => $case->files->max('updated_at'),
        ];
    }

    private function buildProgress(array $stats): int
    {
        if ($stats['totalFiles'] <= 0) {
            return 0;
        }

        return (int) round(($stats['unlockedFiles'] / $stats['totalFiles']) * 100);
    }
}