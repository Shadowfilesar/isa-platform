<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Services\DirectorMessageService;
use Illuminate\Http\Request;

class DirectorMessageController extends Controller
{
    public function create()
    {
        return view(
            'admin.messages.create',
            [
                'players' => Player::orderBy(
                    'account_code'
                )->get(),
            ]
        );
    }

    public function store(
        Request $request,
        DirectorMessageService $service
    ) {

        $data = $request->validate([

            'player_id' => ['required','exists:players,id'],

            'subject' => ['required','max:255'],

            'message' => ['required'],

        ]);

        $player = Player::findOrFail(
            $data['player_id']
        );
                $service->send(

            $player,

            $data['subject'],

            $data['message']

        );

        return redirect()

            ->back()

            ->with(

                'success',

                'Director message sent successfully.'

            );
    }
}