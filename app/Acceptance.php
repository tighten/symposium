<?php

namespace App;

class Acceptance extends UuidBase
{
    protected $table = 'acceptances';

    protected $primaryKey = 'id';

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'talk_revision_id',
        'conference_id',
    ];

    public static function createFromSubmission(Submission $submission)
    {
        return Acceptance::create([
            'talk_revision_id' => $submission->talkRevision->id,
            'conference_id' => $submission->conference->id,
        ]);
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
