<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestigationCase;
use App\Models\MissionCode;
use App\Models\Player;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index', [

            /*
            |--------------------------------------------------------------------------
            | Statistics
            |--------------------------------------------------------------------------
            */

            'totalPlayers' => Player::count(),

            'activePlayers' => Player::where('is_active', true)->count(),

            'inactivePlayers' => Player::where('is_active', false)->count(),

            'totalCases' => InvestigationCase::count(),

            'publishedCases' => InvestigationCase::where('published', true)->count(),

            'draftCases' => InvestigationCase::where('published', false)->count(),

            'totalMissionCodes' => MissionCode::count(),

            'usedMissionCodes' => MissionCode::where('used', true)->count(),

            'unusedMissionCodes' => MissionCode::where('used', false)->count(),

            /*
            |--------------------------------------------------------------------------
            | Recent Data
            |--------------------------------------------------------------------------
            */

            'recentCases' => InvestigationCase::latest()
                ->take(5)
                ->get(),

            'latestPlayers' => Player::latest()
                ->take(5)
                ->get(),

        ]);
    }
}