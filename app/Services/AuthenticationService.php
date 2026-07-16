<?php

namespace App\Services;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{
    public function login(Request $request)
    {
        $request->validate([
            'account_code' => ['required'],
            'password'     => ['nullable'],
        ]);

        $player = Player::where(
            'account_code',
            $request->account_code
        )->first();

        if (!$player) {
            return back()
                ->withErrors([
                    'account_code' => 'Invalid account code.'
                ]);
        }

        if (!$player->isActivated()) {
            return redirect()->route(
                'activation.create',
                $player->account_code
            );
        }

        if (!Hash::check(
            $request->password,
            $player->password
        )) {
            return back()
                ->withErrors([
                    'password' => 'Invalid password.'
                ]);
        }

        $request->session()->regenerate();

        session([
            'player_id' => $player->id,
        ]);

        $player->update([
            'last_login' => now(),
        ]);

        return redirect()->route('dashboard');
    }
        public function activationForm(string $accountCode)
    {
        $player = Player::where(
            'account_code',
            $accountCode
        )->firstOrFail();

        if ($player->isActivated()) {
            return redirect()->route('login');
        }

        return view('auth.create-password', [
            'player' => $player,
        ]);
    }

    public function activate(
        Request $request,
        string $accountCode
    ) {
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                'min:8'
            ],
        ]);

        $player = Player::where(
            'account_code',
            $accountCode
        )->firstOrFail();

        if ($player->isActivated()) {
            return redirect()->route('login');
        }

        $player->update([
            'password' => Hash::make(
                $request->password
            ),
            'last_login' => now(),
        ]);

        $request->session()->regenerate();

        session([
            'player_id' => $player->id,
        ]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('player_id');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}