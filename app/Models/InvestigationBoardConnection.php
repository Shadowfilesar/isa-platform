<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestigationBoardConnection extends Model
{
    protected $table = 'investigation_board_connections';

    protected $fillable = [
        'investigation_board_id',
        'source_board_item_id',
        'target_board_item_id',
        'reason',
        'confidence_level',
    ];

    public function board(): BelongsTo
    {
        return $this->belongsTo(
            InvestigationBoard::class,
            'investigation_board_id'
        );
    }

    public function sourceItem(): BelongsTo
    {
        return $this->belongsTo(
            InvestigationBoardItem::class,
            'source_board_item_id'
        );
    }

    public function targetItem(): BelongsTo
    {
        return $this->belongsTo(
            InvestigationBoardItem::class,
            'target_board_item_id'
        );
    }
}