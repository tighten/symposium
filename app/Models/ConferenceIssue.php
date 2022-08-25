<?php

namespace App\Models;

use App\Models\Conference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConferenceIssue extends Model
{
    use HasFactory;

    public const REASONS = [
        'duplicate',
        'incorrect',
        'spam',
        'other',
    ];

    protected $guarded = [];

    public static function reasonOptions()
    {
        return collect(static::REASONS)->map(function ($reason) {
            return [
                'value' => $reason,
                'text' => __("conference.issues.{$reason}"),
            ];
        });
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }

    public function scopeWhereOpen($query)
    {
        $query->whereNull('closed_at');
    }

    public function getDescriptionAttribute()
    {
        return __("conference.issues.{$this->reason}");
    }
}
