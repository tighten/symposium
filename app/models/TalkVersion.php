<?php

class TalkVersion extends UuidBase
{
    protected $table = 'talk_versions';

    protected $guarded = [
        'id'
    ];

    public static $rules = array();

    public function current()
    {
        return $this->revisions()->orderBy('created_at', 'DESC')->first();
    }

    public function revisions()
    {
        return $this->hasMany('TalkVersionRevision');
    }
}
