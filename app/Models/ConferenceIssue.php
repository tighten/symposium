<?php

namespace App\Models;

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
}
