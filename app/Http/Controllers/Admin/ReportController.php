<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\InvestigationCase;
use App\Models\MissionCode;
use App\Models\Notification;
use App\Models\Player;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index', [

            'totalPlayers' => Player::count(),

            'activePlayers' => Player::where('is_active', true)
                ->count(),

            'inactivePlayers' => Player::where('is_active', false)
                ->count(),

            'totalCases' => InvestigationCase::count(),

            'publishedCases' => InvestigationCase::where('published', true)
                ->count(),

            'draftCases' => InvestigationCase::where('published', false)
                ->count(),

            'totalNotifications' => Notification::count(),

            'readNotifications' => Notification::where('is_read', true)
                ->count(),

            'unreadNotifications' => Notification::where('is_read', false)
                ->count(),

            'totalLogs' => ActivityLog::count(),

            'totalMissionCodes' => MissionCode::count(),

            'usedMissionCodes' => MissionCode::where('used', true)
                ->count(),

            'unusedMissionCodes' => MissionCode::where('used', false)
                ->count(),

        ]);
    }
        public function export(string $type)
    {
        return response()->json([

            'success' => true,

            'message' => "Export '{$type}' is planned for the next pack.",

        ]);
    }

    public function statistics()
    {
        return response()->json([

            'players' => Player::count(),

            'cases' => InvestigationCase::count(),

            'notifications' => Notification::count(),

            'activity_logs' => ActivityLog::count(),

            'mission_codes' => MissionCode::count(),

            'used_codes' => MissionCode::where('used', true)->count(),

            'unused_codes' => MissionCode::where('used', false)->count(),

        ]);
    }
}