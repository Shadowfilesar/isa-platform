<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\XPLog;
use App\Services\XPService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class XPController extends Controller
{
    public function index(Request $request): View
    {
        $players = Player::query()
            ->with(['xpLogs' => fn ($query) => $query->latest()->limit(5)])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim((string) $request->string('search'));
                $query->where(function ($builder) use ($search) {
                    $builder->where('username', 'like', "%{$search}%")
                        ->orWhere('account_code', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        $logs = XPLog::query()
            ->with(['player', 'admin'])
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.xp.index', compact('players', 'logs'));
    }

    public function award(Request $request, Player $player, XPService $service): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'integer', 'min:1', 'max:1000000'],
            'reason' => ['required', 'string', 'max:255'],
            'details' => ['nullable', 'string', 'max:5000'],
        ]);

        $service->award($player, (int) $data['amount'], $data['reason'], $request->user('admin'), $data['details'] ?? null);

        return back()->with('success', 'XP awarded successfully.');
    }

    public function remove(Request $request, Player $player, XPService $service): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'integer', 'min:1', 'max:1000000'],
            'reason' => ['required', 'string', 'max:255'],
            'details' => ['nullable', 'string', 'max:5000'],
        ]);

        $service->remove($player, (int) $data['amount'], $data['reason'], $request->user('admin'), $data['details'] ?? null);

        return back()->with('success', 'XP removed successfully.');
    }
}