<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Services\DirectorMessageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DirectorMessageController extends Controller
{
    public function __construct(
        protected DirectorMessageService $directorMessageService
    ) {
    }

    public function create(): View
    {
        $players = Player::query()
            ->orderBy('account_code')
            ->get();

        return view('admin.messages.create', compact('players'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'player_id' => ['required', 'exists:players,id'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $this->directorMessageService->send(
            (int) $validated['player_id'],
            $validated['subject'],
            $validated['message']
        );

        return redirect()
            ->route('admin.messages.create')
            ->with('success', 'Director message sent successfully.');
    }
}