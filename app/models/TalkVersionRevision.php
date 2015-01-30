<?php

class TalkVersionRevision extends UuidBase
{
    protected $table = 'talk_version_revisions';

    protected $guarded = [
        'id'
    ];

    public static $rules = array();

    public function talkVersion()
    {
        return $this->belongsTo('TalkVersion');
    }

    public function getTalkAttribute()
    {
        return $this->talkVersion->talk;
    }

    public function getUrl()
    {
        return '/talks/' . $this->getAttribute('talk')->id . '/versions/' . $this->talkVersion->id . '/' . $this->id;
    }
}
