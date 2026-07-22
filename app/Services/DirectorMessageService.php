<?php

namespace App\Services;

use App\Models\DirectorMessage;
use Illuminate\Support\Facades\DB;

class DirectorMessageService
{
    public function __construct(
        protected NotificationService $notificationService
    ) {
    }

    public function send(int $playerId, string $subject, string $message): DirectorMessage
    {
        return DB::transaction(function () use ($playerId, $subject, $message) {
            $directorMessage = DirectorMessage::create([
                'player_id' => $playerId,
                'subject' => $subject,
                'message' => $message,
                'is_read' => false,
            ]);

            $this->notificationService->create(
                $playerId,
                $subject,
                $message,
                'director_message'
            );

            return $directorMessage;
        });
    }
}