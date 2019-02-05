<?php

namespace App;

class Submission extends UuidBase
{
    protected $table = 'submissions';

    protected $primaryKey = 'id';

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'talk_revision_id',
        'conference_id',
    ];

    public function talkRevision()
    {
        return $this->belongsTo(TalkRevision::class);
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }

    public function acceptance()
    {
        return $this->belongsTo(Acceptance::class);
    }

    public function recordAcceptance(Acceptance $acceptance)
    {
        $this->acceptance_id = $acceptance->id;
        $this->save();
    }
}
