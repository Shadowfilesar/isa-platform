<?php

namespace App\Http\Controllers;

use App\Models\InvestigationCase;
use App\Services\InvestigationBoardService;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function __construct(
        private readonly InvestigationBoardService $investigationBoardService
    ) {
    }

    public function index(Request $request)
    {
        $player = $request->attributes->get('player');

        $cases = $player->cases()
            ->withPivot(['status', 'started_at', 'completed_at'])
            ->latest()
            ->get();

        return view('dashboard.pages.cases', [
            'player' => $player,
            'cases' => $cases,
        ]);
    }

    public function show(Request $request, InvestigationCase $case)
    {
        $player = $request->attributes->get('player');

        abort_unless(
            $player && $player->cases()->whereKey($case->getKey())->exists(),
            404
        );

        $section = $request->string('section')->toString();
        $section = $section !== '' ? $section : 'Overview';

        $files = $case->files()
            ->orderBy('display_order')
            ->orderBy('id')
            ->get();

        $sectionedFiles = $files->groupBy(function ($file) {
            return $file->section ?: 'Evidence';
        });

        $visibleFiles = $section === 'Overview'
            ? $files
            : $sectionedFiles->get($section, collect());

        $stats = [
            'totalFiles' => $files->count(),
            'lockedFiles' => $files->where('locked', true)->count(),
            'unlockedFiles' => $files->where('locked', false)->count(),
            'totalSections' => $sectionedFiles->keys()->count(),
            'lastUpdated' => $files->max('updated_at'),
        ];

        $progress = $stats['totalFiles'] > 0
            ? (int) round(($stats['unlockedFiles'] / $stats['totalFiles']) * 100)
            : 0;

        $boardWorkspace = $this->investigationBoardService->buildBoardWorkspaceViewData(
            $player,
            $case,
            $section
        );

        return view('dashboard.pages.case', array_merge([
            'player' => $player,
            'playerId' => $player->id,
            'case' => $case,
            'section' => $section,
            'activeSection' => $section,
            'files' => $visibleFiles,
            'filesCollection' => $visibleFiles,
            'evidenceFiles' => $boardWorkspace['evidenceFiles'] ?? collect(),
            'stats' => $stats,
            'progress' => $progress,
        ], $boardWorkspace));
    }
}