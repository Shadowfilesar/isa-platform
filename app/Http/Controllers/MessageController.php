<?php

namespace App\Http\Controllers;

use App\Models\DirectorMessage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Inbox
     */
    public function index(Request $request): View
    {
        $player = $request->attributes->get('player');

        $messages = $player->directorMessages()
            ->latest()
            ->get();

        return view('dashboard.messages.index', [
            'player'   => $player,
            'messages' => $messages,
        ]);
    }

    /**
     * Open Message
     */
    public function show(Request $request, DirectorMessage $message): View
    {
        $player = $request->attributes->get('player');

        abort_unless(
            $message->player_id === $player->id,
            403
        );

        if (! $message->is_read) {

            $message->update([
                'is_read' => true,
            ]);

            $player->notifications()
                ->where('is_read', false)
                ->where('type', 'director_message')
                ->update([
                    'is_read' => true,
                ]);
        }

        return view('dashboard.messages.show', [
            'player'  => $player,
            'message' => $message,
        ]);
    }
}