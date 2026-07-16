<?php

namespace App\Http\Controllers;

use App\Services\MissionCodeService;
use App\Services\PlayerService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected PlayerService $playerService,
        protected MissionCodeService $missionCodeService
    ) {
    }

    public function index(Request $request)
    {
        $player = $request->attributes->get('player');

        return view('dashboard.pages.home', [
            ...$this->playerService->dashboard($player),
        ]);
    }

    public function archive(Request $request)
    {
        return view('dashboard.pages.archive', [
            'player' => $request->attributes->get('player'),
        ]);
    }

    public function redeem(Request $request)
    {
        $request->validate([
            'code' => ['required'],
        ]);

        $player = $request->attributes->get('player');

        $success = $this->missionCodeService->redeem(
            $player,
            $request->code
        );

        if (!$success) {

            return back()->withErrors([
                'code' => 'Invalid mission code.',
            ]);

        }

        return redirect()
            ->route('cases.index')
            ->with(
                'success',
                'Mission unlocked successfully.'
            );
    }
}