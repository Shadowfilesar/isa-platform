<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [

        'player_id',

        'type',

        'title',

        'message',

        'icon',

        'color',

        'link',

        'is_read',

    ];

    protected $casts = [

        'is_read' => 'boolean',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function player(): BelongsTo
    {
        return $this->belongsTo(
            Player::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function markAsRead(): void
    {
        $this->update([

            'is_read' => true,

        ]);
    }

    public function markAsUnread(): void
    {
        $this->update([

            'is_read' => false,

        ]);
    }

    public function isUnread(): bool
    {
        return ! $this->is_read;
    }
}