<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bio extends UuidBase
{
    use HasFactory;

    protected $table = 'bios';

    protected $fillable = [
        'user_id',
        'nickname',
        'public',
        'body',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPreviewAttribute()
    {
        return substr($this->getAttribute('body'), 0, 100) . '...';
    }

    public function scopePublic($query)
    {
        return $query->where('public', true);
    }
}
