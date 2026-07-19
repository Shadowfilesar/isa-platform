<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestigationCase;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->get('search', ''));

        $players = Player::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder->where('account_code', 'like', "%{$search}%")
                        ->orWhere('rank', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.players.index', compact('players', 'search'));
    }

    public function create()
    {
        return view('admin.players.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_code' => ['required', 'string', 'max:255', 'unique:players,account_code'],
            'password' => ['required', 'string', 'min:6'],
            'rank' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'integer', 'min:1'],
            'xp' => ['nullable', 'integer', 'min:0'],
        ]);

        Player::create([
            'account_code' => $validated['account_code'],
            'password' => Hash::make($validated['password']),
            'rank' => $validated['rank'] ?? 'Recruit',
            'level' => $validated['level'] ?? 1,
            'xp' => $validated['xp'] ?? 0,
        ]);

        return redirect()
            ->route('admin.players.index')
            ->with('success', 'Player created successfully.');
    }

    public function edit(Player $player)
    {
        return view('admin.players.edit', compact('player'));
    }

    public function update(Request $request, Player $player)
    {
        $validated = $request->validate([
            'account_code' => ['required', 'string', 'max:255', "unique:players,account_code,{$player->id}"],
            'password' => ['nullable', 'string', 'min:6'],
            'rank' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'integer', 'min:1'],
            'xp' => ['nullable', 'integer', 'min:0'],
        ]);

        $player->account_code = $validated['account_code'];
        $player->rank = $validated['rank'] ?? $player->rank;
        $player->level = $validated['level'] ?? $player->level;
        $player->xp = $validated['xp'] ?? $player->xp;

        if (! empty($validated['password'])) {
            $player->password = Hash::make($validated['password']);
        }

        $player->save();

        return redirect()
            ->route('admin.players.index')
            ->with('success', 'Player updated successfully.');
    }

    public function destroy(Player $player)
    {
        $player->delete();

        return redirect()
            ->route('admin.players.index')
            ->with('success', 'Player deleted successfully.');
    }

    public function assignCases(Player $player)
    {
        $cases = InvestigationCase::query()
            ->orderBy('title')
            ->get();

        $assignedCases = $player->cases()
            ->pluck('cases.id')
            ->toArray();

        return view('admin.players.assign-cases', compact('player', 'cases', 'assignedCases'));
    }

    public function saveAssignedCases(Request $request, Player $player)
    {
        $validated = $request->validate([
            'cases' => ['nullable', 'array'],
            'cases.*' => ['integer', 'exists:cases,id'],
        ]);

        $player->cases()->sync($validated['cases'] ?? []);

        return redirect()
            ->route('admin.players.index')
            ->with('success', 'Assigned cases updated successfully.');
    }
}