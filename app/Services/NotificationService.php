<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Player;

class NotificationService
{
    /**
     * Send a notification to one player.
     */
    public function sendToPlayer(
        Player $player,
        string $type,
        string $title,
        string $message,
        ?string $link = null,
        string $icon = 'bell',
        string $color = 'blue'
    ): Notification {

        return Notification::create([

            'player_id' => $player->id,

            'type' => $type,

            'title' => $title,

            'message' => $message,

            'icon' => $icon,

            'color' => $color,

            'link' => $link,

            'is_read' => false,

        ]);
    }

    /**
     * Send the same notification to every player.
     */
    public function sendToAllPlayers(
        string $type,
        string $title,
        string $message,
        ?string $link = null,
        string $icon = 'bell',
        string $color = 'blue'
    ): void {

        Player::query()

            ->chunk(100, function ($players) use (

                $type,
                $title,
                $message,
                $link,
                $icon,
                $color

            ) {

                foreach ($players as $player) {

                    $this->sendToPlayer(

                        $player,

                        $type,

                        $title,

                        $message,

                        $link,

                        $icon,

                        $color

                    );
                }

            });
    }

    /**
     * Mark one notification as read.
     */
    public function markAsRead(
        Notification $notification
    ): void {

        if (! $notification->is_read) {

            $notification->update([

                'is_read' => true,

            ]);
        }
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(
        Player $player
    ): void {

        $player->notifications()

            ->where('is_read', false)

            ->update([

                'is_read' => true,

            ]);
    }

    /**
     * Count unread notifications.
     */
    public function unreadCount(
        Player $player
    ): int {

        return $player->notifications()

            ->where('is_read', false)

            ->count();
    }
}