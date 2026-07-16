<?php

namespace App\Http\Controllers;

use App\Services\CaseFileService;
use Illuminate\Http\Request;

class CaseFileController extends Controller
{
    public function __construct(
        protected CaseFileService $caseFileService
    ) {
    }

    /**
     * Display one investigation file.
     */
    public function show(
        Request $request,
        string $case,
        int $file
    ) {
        $player = $request->attributes->get('player');

        $adjacentFiles = $this->caseFileService
            ->adjacentFiles($player, $case, $file);

        return view('dashboard.pages.file', [

            'player' => $player,

            'case' => $this->caseFileService
                ->playerCase($player, $case),

            'file' => $this->caseFileService
                ->playerFile($player, $case, $file),

            'previousFile' => $adjacentFiles['previous'] ?? null,

            'nextFile' => $adjacentFiles['next'] ?? null,

        ]);
    }
}