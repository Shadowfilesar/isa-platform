<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestigationCase;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->get('search', ''));
        $status = trim((string) $request->get('status', ''));

        $players = Player::query()
            ->withCount('cases')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder->where('account_code', 'like', "%{$search}%")
                        ->orWhere('rank', 'like', "%{$search}%");
                });
            })
            ->when($status === 'active', function ($query) {
                $query->whereNotNull('password');
            })
            ->when($status === 'inactive', function ($query) {
                $query->whereNull('password');
            })
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        $totalPlayers = Player::count();
        $activePlayers = Player::whereNotNull('password')->count();
        $inactivePlayers = Player::whereNull('password')->count();
        $totalAssignedCases = DB::table('player_cases')->count();

        return view('admin.players.index', compact(
            'players',
            'totalPlayers',
            'activePlayers',
            'inactivePlayers',
            'totalAssignedCases',
            'search',
            'status'
        ));
    }

    public function create()
    {
        $lastPlayer = Player::query()->latest('id')->first();
        $nextNumber = $lastPlayer ? ($lastPlayer->id + 1) : 1;
        $suggestedAccountCode = 'ISA-INVS-' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);

        return view('admin.players.create', compact('suggestedAccountCode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_code' => ['required', 'string', 'max:255', 'unique:players,account_code'],
            'password' => ['nullable', 'string', 'min:6'],
            'level' => ['required', 'integer', 'min:1'],
            'xp' => ['required', 'integer', 'min:0'],
            'rank' => ['required', 'string', 'max:255'],
        ]);

        Player::create([
            'account_code' => $validated['account_code'],
            'password' => filled($validated['password'] ?? null) ? Hash::make($validated['password']) : null,
            'level' => $validated['level'],
            'xp' => $validated['xp'],
            'rank' => $validated['rank'],
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
            'account_code' => ['required', 'string', 'max:255', 'unique:players,account_code,' . $player->id],
            'password' => ['nullable', 'string', 'min:6'],
            'level' => ['required', 'integer', 'min:1'],
            'xp' => ['required', 'integer', 'min:0'],
            'rank' => ['required', 'string', 'max:255'],
        ]);

        $data = [
            'account_code' => $validated['account_code'],
            'level' => $validated['level'],
            'xp' => $validated['xp'],
            'rank' => $validated['rank'],
        ];

        if (filled($validated['password'] ?? null)) {
            $data['password'] = Hash::make($validated['password']);
        }

        $player->update($data);

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
        $cases = InvestigationCase::orderBy('title')->get();
        $assignedCases = $player->cases()->pluck('cases.id')->toArray();

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
            ->route('admin.players.edit', $player)
            ->with('success', 'Assigned cases updated successfully.');
    }
}