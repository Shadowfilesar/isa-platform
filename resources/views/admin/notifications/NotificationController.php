<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Player;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::query()
            ->with('player')
            ->latest()
            ->paginate(20);

        return view(
            'admin.notifications.index',
            compact('notifications')
        );
    }

    public function create()
    {
        $players = Player::query()
            ->orderBy('account_code')
            ->get();

        return view(
            'admin.notifications.create',
            compact('players')
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([

            'player_id' => [
                'required',
                'exists:players,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'message' => [
                'required',
                'string',
            ],

        ]);

        Notification::create([

            'player_id' => $data['player_id'],

            'title' => $data['title'],

            'message' => $data['message'],

            'read_at' => null,

        ]);

        return redirect()
            ->route('admin.notifications.index')
            ->with(
                'success',
                'Notification sent successfully.'
            );
    }
        public function show(Notification $notification)
    {
        $notification->load('player');

        return view(
            'admin.notifications.show',
            compact('notification')
        );
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()
            ->route('admin.notifications.index')
            ->with(
                'success',
                'Notification deleted successfully.'
            );
    }

    /**
     * Send notification to all players.
     */
    public function broadcast(Request $request)
    {
        $data = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'message' => [
                'required',
                'string',
            ],

        ]);

        Player::query()
            ->chunk(100, function ($players) use ($data) {

                foreach ($players as $player) {

                    Notification::create([

                        'player_id' => $player->id,

                        'title' => $data['title'],

                        'message' => $data['message'],

                        'read_at' => null,

                    ]);

                }

            });

        return redirect()
            ->route('admin.notifications.index')
            ->with(
                'success',
                'Notification sent to all players.'
            );
    }
        /**
     * Mark notification as read.
     */
    public function markAsRead(Notification $notification)
    {
        $notification->update([

            'read_at' => now(),

        ]);

        return redirect()
            ->route(
                'admin.notifications.show',
                $notification
            )
            ->with(
                'success',
                'Notification marked as read.'
            );
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Notification::query()
            ->whereNull('read_at')
            ->update([

                'read_at' => now(),

            ]);

        return redirect()
            ->route('admin.notifications.index')
            ->with(
                'success',
                'All notifications marked as read.'
            );
    }
}