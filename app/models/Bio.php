<?php

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Bio extends UuidBase
{
    protected $table = 'bios';

    protected $fillable = [
        'user_id',
        'nickname',
        'body'
    ];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function getPreviewAttribute()
    {
        return substr($this->getAttribute('body'), 0, 100) . '...';
    }
}
