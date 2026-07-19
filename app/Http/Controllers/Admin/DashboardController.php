<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestigationCase;
use App\Models\MissionCode;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index', [

            'totalCases' => InvestigationCase::query()
                ->count(),

            'totalMissionCodes' => MissionCode::query()
                ->count(),

            'usedMissionCodes' => MissionCode::query()
                ->where('used', true)
                ->count(),

            'unusedMissionCodes' => MissionCode::query()
                ->where('used', false)
                ->count(),

            'recentCases' => InvestigationCase::query()
                ->latest()
                ->limit(5)
                ->get(),

        ]);
    }
}
