<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestigationCase extends Model
{
    protected $table = 'cases';

    protected $fillable = [
        'code',
        'title',
        'description',
        'difficulty',
        'cover_image',
        'published',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function players()
    {
        return $this->belongsToMany(
            Player::class,
            'player_cases',
            'case_id',
            'player_id'
        )->withPivot([
            'status',
            'assigned_at',
            'started_at',
            'completed_at'
        ]);
    }

    public function files()
    {
        return $this->hasMany(
            CaseFile::class,
            'case_id'
        )->orderBy('display_order');
    }
}