<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    protected $table = 'players';

    protected $fillable = [
        'account_code',
        'password',
        'level',
        'xp',
        'rank',
        'last_login',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'last_login' => 'datetime',
        ];
    }

    public function isActivated(): bool
    {
        return $this->password !== null;
    }

    public function cases(): BelongsToMany
    {
        return $this->belongsToMany(
            InvestigationCase::class,
            'player_cases',
            'player_id',
            'case_id'
        )->withTimestamps();
    }
 public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'player_id');
    }

    public function directorMessages(): HasMany
    {
        return $this->hasMany(DirectorMessage::class, 'player_id');
    }
}