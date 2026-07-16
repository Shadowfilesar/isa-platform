<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MissionCode extends Model
{
    protected $table = 'mission_codes';

    protected $fillable = [
        'activation_code',
        'case_id',
        'used',
        'used_by',
        'activated_at',
    ];

    protected function casts(): array
    {
        return [
            'used' => 'boolean',
            'activated_at' => 'datetime',
        ];
    }

    public function investigationCase(): BelongsTo
    {
        return $this->belongsTo(
            InvestigationCase::class,
            'case_id'
        );
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(
            Player::class,
            'used_by'
        );
    }
}
