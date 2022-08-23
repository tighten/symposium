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
}
