<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [

        'player_id',

        'type',

        'title',

        'description',

        'icon',

    ];

    public function player()
    {
        return $this->belongsTo(
            Player::class
        );
    }
}