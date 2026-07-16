<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseFile extends Model
{
    use HasFactory;

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
        'file_size' => 'integer',
        'display_order' => 'integer',
        'locked' => 'boolean',
        'public' => 'boolean',
        'preview_count' => 'integer',
        'download_count' => 'integer',
        'parent_file_id' => 'integer',
        'version' => 'integer',
        'is_current' => 'boolean',
    ];

    public function investigationCase()
    {
        return $this->belongsTo(InvestigationCase::class, 'case_id');
    }

    public function uploader()
    {
        return $this->belongsTo(Player::class, 'uploaded_by');
    }

    public function updater()
    {
        return $this->belongsTo(Player::class, 'updated_by');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_file_id');
    }

    public function versions()
    {
        return $this->hasMany(self::class, 'parent_file_id');
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }
}