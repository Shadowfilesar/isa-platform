<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseFile extends Model
{
    protected $table = 'case_files';

    protected $fillable = [
        'case_id',
        'category',
        'section',
        'title',
        'description',
        'file_name',
        'original_name',
        'mime_type',
        'file_size',
        'extension',
        'file_path',
        'display_order',
        'locked',
        'public',
        'unlock_event',
        'required_rank',
        'required_clearance',
        'uploaded_by',
        'updated_by',
        'preview_count',
        'download_count',
        'sha256',
        'parent_file_id',
        'version',
        'is_current',
    ];

    protected $casts = [
        'locked' => 'boolean',
        'public' => 'boolean',
        'is_current' => 'boolean',
    ];

    public function investigationCase(): BelongsTo
    {
        return $this->belongsTo(InvestigationCase::class, 'case_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'uploaded_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_file_id');
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }
}