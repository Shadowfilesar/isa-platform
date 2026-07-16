<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Player extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'account_code',
        'password',
        'rank',
        'clearance_level',
        'status',
        'xp',
        'total_xp',
        'level',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_login' => 'datetime',
        'level' => 'integer',
        'xp' => 'integer',
        'total_xp' => 'integer',
        'is_active' => 'boolean',
    ];

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
        return $this->hasMany(Notification::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function directorMessages(): HasMany
    {
        return $this->hasMany(DirectorMessage::class);
    }

    public function xpLogs(): HasMany
    {
        return $this->hasMany(XPLog::class);
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(PlayerAchievement::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}