<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseFile extends Model
{
    protected $table = 'case_files';

    protected $fillable = [
        'case_id',
        'section',
        'title',
        'description',
        'file_type',
        'file_path',
        'display_order',
        'locked',
    ];

    protected $casts = [
        'locked' => 'boolean',
    ];

    public function investigationCase()
    {
        return $this->belongsTo(
            InvestigationCase::class,
            'case_id'
        );
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }
}