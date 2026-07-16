<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Player;
use Illuminate\Http\Request;

class AuthenticatePlayer
{
    public function handle(
        Request $request,
        Closure $next
    ) {
        if (!session()->has('player_id')) {

            return redirect()->route('login');

        }

        $player = Player::find(
            session('player_id')
        );

        if (!$player) {

            session()->invalidate();

            return redirect()->route('login');

        }

        $request->attributes->set(
            'player',
            $player
        );

        return $next($request);
    }
}