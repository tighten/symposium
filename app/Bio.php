<?php

namespace App;

class Bio extends UuidBase
{
    protected $table = 'bios';

    protected $fillable = [
        'user_id',
        'nickname',
        'public',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo('User');
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
