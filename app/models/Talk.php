<?php

class Talk extends UuidBase
{
    protected $table = 'talks';

    protected $guarded = [
        'id'
    ];

    public static $rules = [];

    public function author()
    {
        return $this->belongsTo('User', 'author_id');
    }

//    public function submissions()
//    {
//        return $this->belongsToMany('Conference');
//    }

    public function current()
    {
        return $this->revisions()->orderBy('created_at', 'DESC')->first();
    }

    public function revisions()
    {
        return $this->hasMany('TalkRevision');
    }

    public function getRevisionsAttribute()
    {
        return $this->revisions()->getQuery()->orderBy('created_at', 'desc')->get();
    }
}
