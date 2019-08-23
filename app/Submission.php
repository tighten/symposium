<?php

namespace App;

class Submission extends UuidBase
{
    protected $table = 'submissions';

    protected $primaryKey = 'id';

    protected $guarded = [
        'id',
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

    public function scopeAccepted($query)
    {
        return $query->whereNotNull('acceptance_id');
    }

    public function removeAcceptance()
    {
        $this->acceptance_id = null;
        $this->save();
    }

    public function recordAcceptance(Acceptance $acceptance)
    {
        $this->acceptance_id = $acceptance->id;
        $this->save();
    }

    public function isAccepted()
    {
        return $this->acceptance_id !== null;
    }
}
