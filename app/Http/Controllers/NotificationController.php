<?php

namespace App\Http\Controllers;

use App\Models\DirectorMessage;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $player = $request->attributes->get('player');

        $notifications = $player
            ->notifications()
            ->latest()
            ->paginate(20);

        $unreadNotifications = $player
            ->notifications()
            ->where('is_read', false)
            ->count();

        $unreadMessages = DirectorMessage::query()
            ->where('player_id', $player->id)
            ->whereNull('read_at')
            ->count();

        return view(
            'dashboard.notifications.index',
            [
                'player'              => $player,
                'notifications'       => $notifications,
                'unreadNotifications' => $unreadNotifications,
                'unreadMessages'      => $unreadMessages,
            ]
        );
    }

    public function read(
        Request $request,
        Notification $notification,
        NotificationService $service
    ) {
        $player = $request->attributes->get('player');

        abort_if(
            $notification->player_id !== $player->id,
            404
        );

        $service->markAsRead(
            $notification
        );

        if ($notification->link) {

            return redirect(
                $notification->link
            );
        }

        return back();
    }

    public function readAll(
        Request $request,
        NotificationService $service
    ) {
        $player = $request->attributes->get('player');

        $service->markAllAsRead(
            $player
        );

        return back();
    }
}