<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}