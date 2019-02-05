<?php

namespace App;

class Acceptance extends UuidBase
{
    protected $table = 'acceptances';

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
      'talk_revision_id',
      'conference_id',
    ];

    public function talkRevision()
    {
        return $this->hasOne(TalkRevision::class);
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
}
