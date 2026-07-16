<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('player');

        if ($request->filled('search')) {

            $query->whereHas('player', function ($q) use ($request) {

                $q->where(
                    'account_code',
                    'like',
                    '%' . $request->search . '%'
                );

            });

        }

        if ($request->filled('action')) {

            $query->where(
                'action',
                'like',
                '%' . $request->action . '%'
            );

        }

        if ($request->filled('date')) {

            $query->whereDate(
                'created_at',
                $request->date
            );

        }

        $logs = $query
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view(
            'admin.activity-logs.index',
            compact('logs')
        );
    }

    public function show(ActivityLog $activityLog)
    {
        return view(
            'admin.activity-logs.show',
            [
                'log' => $activityLog->load('player'),
            ]
        );
    }

    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();

        return redirect()
            ->route('admin.activity-logs.index')
            ->with(
                'success',
                'Activity log deleted successfully.'
            );
    }

    public function clear()
    {
        ActivityLog::query()->delete();

        return redirect()
            ->route('admin.activity-logs.index')
            ->with(
                'success',
                'All activity logs have been deleted.'
            );
    }
        public function export()
    {
        $logs = ActivityLog::with('player')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'count'   => $logs->count(),
            'data'    => $logs,
        ]);
    }

    public function statistics()
    {
        return response()->json([

            'total_logs' => ActivityLog::count(),

            'today_logs' => ActivityLog::whereDate(
                'created_at',
                today()
            )->count(),

            'this_month_logs' => ActivityLog::whereMonth(
                'created_at',
                now()->month
            )->whereYear(
                'created_at',
                now()->year
            )->count(),

        ]);
    }
}