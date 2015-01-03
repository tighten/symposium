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
}
