<?php

namespace App\Http\Controllers;

use App\Services\CaseFileService;
use App\Services\CaseService;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function __construct(
        protected CaseService $caseService,
        protected CaseFileService $caseFileService
    ) {
    }

    /**
     * Cases List
     */
    public function index(Request $request)
    {
        $player = $request->attributes->get('player');

        return view('dashboard.pages.cases', [
            'player' => $player,
            'cases'  => $this->caseService->playerCases($player),
        ]);
    }

    /**
     * Case Page
     */
    public function show(Request $request, string $code)
    {
        $validated = $request->validate([

            'search' => ['nullable','string','max:255'],

        ]);

        $player = $request->attributes->get('player');

        $case = $this->caseService->playerCase(
            $player,
            $code
        );

        $search = $validated['search'] ?? null;

        return view('dashboard.pages.case', [
            'player'   => $player,
            'case'     => $case,
            'search'   => $search,
            'stats'    => $this->caseFileService->contentStats(
                $player,
                $code
            ),
            'sections' => $this->caseFileService->groupedFiles(
                $player,
                $code,
                $search
            ),
        ]);
    }

    /**
     * Reports
     */
    public function reports(Request $request, string $code)
    {
        return $this->show($request, $code);
    }

    /**
     * Evidence
     */
    public function evidence(Request $request, string $code)
    {
        return $this->show($request, $code);
    }

    /**
     * Witnesses
     */
    public function witnesses(Request $request, string $code)
    {
        return $this->show($request, $code);
    }

    /**
     * Suspects
     */
    public function suspects(Request $request, string $code)
    {
        return $this->show($request, $code);
    }

    /**
     * Documents
     */
    public function documents(Request $request, string $code)
    {
        return $this->show($request, $code);
    }

    /**
     * Timeline
     */
    public function timeline(Request $request, string $code)
    {
        return $this->show($request, $code);
    }

    /**
     * Notes
     */
    public function notes(Request $request, string $code)
    {
        return $this->show($request, $code);
    }

    /**
     * Submit Report
     */
    public function submitReport(Request $request, string $code)
    {
        return $this->show($request, $code);
    }
}
