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
        $notifications = Notification::with('player')
            ->latest()
            ->paginate(20);

        return view(
            'admin.notifications.index',
            compact('notifications')
        );
    }

    public function create()
    {
        $players = Player::orderBy('account_code')->get();

        return view(
            'admin.notifications.create',
            compact('players')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'player_id' => ['required','exists:players,id'],

            'title' => ['required','string','max:255'],

            'message' => ['required','string'],

        ]);

        Notification::create([

            'player_id' => $validated['player_id'],

            'type' => 'system',

            'title' => $validated['title'],

            'message' => $validated['message'],

            'icon' => 'fa-solid fa-bell',

            'color' => 'amber',

            'link' => null,

            'is_read' => false,

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

    public function broadcast(Request $request)
    {
        $validated = $request->validate([

            'title' => ['required','string','max:255'],

            'message' => ['required','string'],

        ]);

        Player::chunk(100, function ($players) use ($validated) {

            foreach ($players as $player) {

                Notification::create([

                    'player_id' => $player->id,

                    'type' => 'system',

                    'title' => $validated['title'],

                    'message' => $validated['message'],

                    'icon' => 'fa-solid fa-bell',

                    'color' => 'amber',

                    'link' => null,

                    'is_read' => false,

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

    public function markAsRead(Notification $notification)
    {
        $notification->update([

            'is_read' => true,

        ]);

        return redirect()
            ->route('admin.notifications.show', $notification)
            ->with(
                'success',
                'Notification marked as read.'
            );
    }

    public function markAllAsRead()
    {
        Notification::where('is_read', false)
            ->update([
                'is_read' => true,
            ]);

        return redirect()
            ->route('admin.notifications.index')
            ->with(
                'success',
                'All notifications marked as read.'
            );
    }
}