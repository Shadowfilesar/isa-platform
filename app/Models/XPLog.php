<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class XPLog extends Model
{
    use HasFactory;

    protected $table = 'xp_logs';

    protected $fillable = [
        'player_id',
        'admin_id',
        'amount',
        'type',
        'reason',
        'details',
        'balance_before',
        'balance_after',
    ];

    protected $casts = [
        'player_id' => 'integer',
        'admin_id' => 'integer',
        'amount' => 'integer',
        'balance_before' => 'integer',
        'balance_after' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}