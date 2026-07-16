<?php

namespace App\Http\Controllers;

use App\Models\DirectorMessage;
use App\Models\Notification;
use App\Services\DirectorMessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $player = $request->attributes->get('player');

        $messages = $player
            ->directorMessages()
            ->latest()
            ->paginate(20);

        $unreadMessages = $player
            ->directorMessages()
            ->whereNull('read_at')
            ->count();

        $unreadNotifications = $player
            ->notifications()
            ->where('is_read', false)
            ->count();

        return view(
            'dashboard.messages.index',
            [
                'player'                => $player,
                'messages'              => $messages,
                'unreadMessages'        => $unreadMessages,
                'unreadNotifications'   => $unreadNotifications,
            ]
        );
    }

    public function show(
        Request $request,
        DirectorMessage $message,
        DirectorMessageService $service
    ) {
        $player = $request->attributes->get('player');

        abort_if(
            $message->player_id !== $player->id,
            404
        );

        $service->markAsRead(
            $message
        );

        $unreadMessages = $player
            ->directorMessages()
            ->whereNull('read_at')
            ->count();

        $unreadNotifications = $player
            ->notifications()
            ->where('is_read', false)
            ->count();

        return view(
            'dashboard.messages.show',
            [
                'player'                => $player,
                'message'               => $message,
                'unreadMessages'        => $unreadMessages,
                'unreadNotifications'   => $unreadNotifications,
            ]
        );
    }
}