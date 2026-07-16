<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestigationCase;
use App\Models\Player;
use App\Services\AchievementService;
use App\Services\ClearanceService;
use App\Services\RankService;
use App\Services\XPService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PlayerController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->get('search', ''));

        $players = Player::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder->where('username', 'like', "%{$search}%")
                        ->orWhere('account_code', 'like', "%{$search}%")
                        ->orWhere('rank', 'like', "%{$search}%")
                        ->orWhere('clearance_level', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.players.index', compact('players', 'search'));
    }

    public function create(ClearanceService $clearanceService): View
    {
        $clearanceLevels = $clearanceService->all();

        return view('admin.players.create', compact('clearanceLevels'));
    }

    public function store(
        Request $request,
        RankService $rankService,
        ClearanceService $clearanceService,
        AchievementService $achievementService
    ): RedirectResponse {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:players,username'],
            'account_code' => ['required', 'string', 'max:255', 'unique:players,account_code'],
            'password' => ['required', 'string', 'min:6'],
            'rank' => ['nullable', 'string', 'max:255'],
            'clearance_level' => ['nullable', 'string', Rule::in($clearanceService->all())],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $player = Player::create([
            'username' => $validated['username'],
            'account_code' => $validated['account_code'],
            'password' => Hash::make($validated['password']),
            'rank' => $validated['rank'] ?? 'Recruit',
            'clearance_level' => $validated['clearance_level'] ?? null,
            'status' => $validated['status'],
            'xp' => 0,
            'total_xp' => 0,
            'level' => 1,
        ]);

        $rankService->sync($player);
        $clearanceService->update($player, $validated['clearance_level'] ?? null);
        $achievementService->check($player);

        return redirect()
            ->route('admin.players.index')
            ->with('success', 'Player created successfully.');
    }

    public function edit(
        Player $player,
        XPService $xpService,
        RankService $rankService,
        ClearanceService $clearanceService,
        AchievementService $achievementService
    ): View {
        if ((int) $player->level !== $xpService->calculateLevel((int) $player->xp)) {
            $player = $xpService->syncLevel($player);
        }

        if ((string) $player->rank !== $rankService->determineRank((int) $player->xp)) {
            $player = $rankService->sync($player);
        }

        $achievementService->check($player);

        $player->load([
            'xpLogs' => fn ($query) => $query->with('admin')->latest(),
            'cases',
            'achievements.achievement',
        ]);

        $clearanceLevels = $clearanceService->all();
        $currentXp = max(0, (int) $player->xp);
        $currentLevel = max(1, (int) $player->level);
        $currentLevelFloorXp = max(0, ($currentLevel - 1) * 1000);
        $nextLevelFloorXp = $currentLevel * 1000;
        $xpIntoLevel = max(0, $currentXp - $currentLevelFloorXp);
        $xpRequiredForNextLevel = max(1, $nextLevelFloorXp - $currentLevelFloorXp);
        $xpProgressPercent = min(
            100,
            max(
                0,
                (int) floor(($xpIntoLevel / $xpRequiredForNextLevel) * 100)
            )
        );

        $playerAchievements = $achievementService->playerAchievements($player);
        $allAchievements = $achievementService->availableAchievements();
        $earnedAchievementIds = $playerAchievements->pluck('achievement_id')->all();
        $lockedAchievements = $allAchievements->filter(
            fn ($achievement) => ! in_array($achievement->id, $earnedAchievementIds, true)
        )->values();

        return view('admin.players.edit', compact(
            'player',
            'clearanceLevels',
            'currentXp',
            'currentLevel',
            'currentLevelFloorXp',
            'nextLevelFloorXp',
            'xpIntoLevel',
            'xpRequiredForNextLevel',
            'xpProgressPercent',
            'playerAchievements',
            'lockedAchievements',
            'allAchievements'
        ));
    }

    public function update(
        Request $request,
        Player $player,
        RankService $rankService,
        ClearanceService $clearanceService,
        AchievementService $achievementService
    ): RedirectResponse {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('players', 'username')->ignore($player->id)],
            'account_code' => ['required', 'string', 'max:255', Rule::unique('players', 'account_code')->ignore($player->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'rank' => ['nullable', 'string', 'max:255'],
            'clearance_level' => ['nullable', 'string', Rule::in($clearanceService->all())],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $player->username = $validated['username'];
        $player->account_code = $validated['account_code'];
        $player->status = $validated['status'];

        if (! empty($validated['password'])) {
            $player->password = Hash::make($validated['password']);
        }

        $player->save();

        $rankService->sync($player);
        $clearanceService->update($player, $validated['clearance_level'] ?? null);
        $achievementService->check($player);

        return redirect()
            ->route('admin.players.edit', $player)
            ->with('success', 'Player updated successfully.');
    }

    public function destroy(Player $player): RedirectResponse
    {
        $player->delete();

        return redirect()
            ->route('admin.players.index')
            ->with('success', 'Player deleted successfully.');
    }

    public function assignCases(Player $player): View
    {
        $cases = InvestigationCase::query()
            ->orderBy('title')
            ->get();

        $assignedCases = $player->cases()
            ->pluck('cases.id')
            ->toArray();

        return view('admin.players.assign-cases', compact('player', 'cases', 'assignedCases'));
    }

    public function saveAssignedCases(Request $request, Player $player, AchievementService $achievementService): RedirectResponse
    {
        $validated = $request->validate([
            'cases' => ['nullable', 'array'],
            'cases.*' => ['integer', 'exists:cases,id'],
        ]);

        $player->cases()->sync($validated['cases'] ?? []);
        $achievementService->check($player);

        return redirect()
            ->route('admin.players.edit', $player)
            ->with('success', 'Assigned cases updated successfully.');
    }

    public function awardXp(Request $request, Player $player, XPService $service, AchievementService $achievementService): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'integer', 'min:1', 'max:1000000'],
            'reason' => ['required', 'string', 'max:255'],
            'details' => ['nullable', 'string', 'max:5000'],
        ]);

        $service->award(
            $player,
            (int) $data['amount'],
            $data['reason'],
            $request->user('admin'),
            $data['details'] ?? null
        );

        $achievementService->check($player->fresh());

        return redirect()
            ->route('admin.players.edit', $player)
            ->with('success', 'XP awarded successfully.');
    }

    public function removeXp(Request $request, Player $player, XPService $service, AchievementService $achievementService): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'integer', 'min:1', 'max:1000000'],
            'reason' => ['required', 'string', 'max:255'],
            'details' => ['nullable', 'string', 'max:5000'],
        ]);

        $service->remove(
            $player,
            (int) $data['amount'],
            $data['reason'],
            $request->user('admin'),
            $data['details'] ?? null
        );

        $achievementService->check($player->fresh());

        return redirect()
            ->route('admin.players.edit', $player)
            ->with('success', 'XP removed successfully.');
    }
}