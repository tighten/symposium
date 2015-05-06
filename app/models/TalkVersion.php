<?php

class TalkVersion extends UuidBase
{
    protected $table = 'talk_versions';

    protected $guarded = [
        'id'
    ];

    public static $rules = array();

    public function talk()
    {
        return $this->belongsTo('Talk');
    }

    public function current()
    {
        return $this->revisions()->orderBy('created_at', 'DESC')->first();
    }

    public function revisions()
    {
        return $this->hasMany('TalkVersionRevision');
    }

    public function getRevisionsAttribute()
    {
        return $this->revisions()->getQuery()->orderBy('created_at', 'desc')->get();
    }

    public function getPublicIdAttribute()
    {
        return md5($this->id . getenv('url_salt') . $this->talk->id);
    }
}
