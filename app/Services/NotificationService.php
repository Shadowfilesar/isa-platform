<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public function create(int $playerId, string $title, string $message, string $type = 'general'): Notification
    {
        return Notification::create([
            'player_id' => $playerId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'is_read' => false,
        ]);
    }
}