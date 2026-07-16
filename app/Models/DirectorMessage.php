<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DirectorMessage extends Model
{
    protected $fillable = [

        'player_id',

        'subject',

        'message',

        'read_at',

    ];

    protected function casts(): array
    {
        return [

            'read_at' => 'datetime',

        ];
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(

            Player::class

        );
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }
}