<?php

namespace App\Services;

use App\Models\DirectorMessage;
use App\Models\Player;

class DirectorMessageService
{
    public function __construct(
        protected NotificationService $notificationService
    ) {
    }

    /**
     * Send a message from the Director.
     */
    public function send(

        Player $player,

        string $subject,

        string $message

    ): DirectorMessage {

        $directorMessage = DirectorMessage::create([

            'player_id' => $player->id,

            'subject' => $subject,

            'message' => $message,

        ]);

        $this->notificationService->sendToPlayer(

            $player,

            'director_message',

            'New Director Message',

            $subject,

            route('messages.index'),

            'mail',

            'blue'

        );

        return $directorMessage;
    }

    /**
     * Mark a message as read.
     */
    public function markAsRead(
        DirectorMessage $message
    ): void {

        if (! $message->read_at) {

            $message->update([

                'read_at' => now(),

            ]);
        }
    }

    /**
     * Count unread messages.
     */
    public function unreadCount(
        Player $player
    ): int {

        return $player->directorMessages()

            ->whereNull('read_at')

            ->count();
    }
}