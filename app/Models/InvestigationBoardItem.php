<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvestigationBoardItem extends Model
{
    protected $table = 'investigation_board_items';

    protected $fillable = [
        'investigation_board_id',
        'case_file_id',
        'is_pinned',
        'position_x',
        'position_y',
        'width',
        'height',
        'z_index',
        'rotation',
        'pinned_at',
        'last_moved_at',
    ];

    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
            'position_x' => 'float',
            'position_y' => 'float',
            'width' => 'float',
            'height' => 'float',
            'rotation' => 'float',
            'pinned_at' => 'datetime',
            'last_moved_at' => 'datetime',
        ];
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(
            InvestigationBoard::class,
            'investigation_board_id'
        );
    }

    public function caseFile(): BelongsTo
    {
        return $this->belongsTo(
            CaseFile::class,
            'case_file_id'
        );
    }

    public function outgoingConnections(): HasMany
    {
        return $this->hasMany(
            InvestigationBoardConnection::class,
            'source_board_item_id'
        );
    }

    public function incomingConnections(): HasMany
    {
        return $this->hasMany(
            InvestigationBoardConnection::class,
            'target_board_item_id'
        );
    }
}