<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'achievement_id',
        'earned_at',
    ];

    protected $casts = [
        'player_id' => 'integer',
        'achievement_id' => 'integer',
        'earned_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function achievement(): BelongsTo
    {
        return $this->belongsTo(Achievement::class);
    }
}