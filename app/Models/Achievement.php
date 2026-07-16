<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'xp_reward',
        'hidden',
    ];

    protected $casts = [
        'xp_reward' => 'integer',
        'hidden' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function playerAchievements(): HasMany
    {
        return $this->hasMany(PlayerAchievement::class);
    }
}