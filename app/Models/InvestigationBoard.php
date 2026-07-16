<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvestigationBoard extends Model
{
    protected $table = 'investigation_boards';

    protected $fillable = [
        'player_id',
        'case_id',
        'name',
        'board_type',
        'is_default',
        'last_saved_at',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
            'last_saved_at' => 'datetime',
        ];
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(
            Player::class,
            'player_id'
        );
    }

    public function investigationCase(): BelongsTo
    {
        return $this->belongsTo(
            InvestigationCase::class,
            'case_id'
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(
            InvestigationBoardItem::class,
            'investigation_board_id'
        )->orderBy('z_index');
    }

    public function connections(): HasMany
    {
        return $this->hasMany(
            InvestigationBoardConnection::class,
            'investigation_board_id'
        );
    }
}