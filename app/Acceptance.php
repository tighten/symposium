<?php

namespace App;

class Acceptance extends UuidBase
{
    protected $table = 'acceptances';

    protected $primaryKey = 'id';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'talk_revision_id',
        'conference_id',
    ];

    public static function createFromSubmission(Submission $submission)
    {
        $acceptance =  Acceptance::create([
            'talk_revision_id' => $submission->talkRevision->id,
            'conference_id' => $submission->conference->id,
        ]);

        $submission->recordAcceptance($acceptance);

        return $acceptance;
    }

    public function submission()
    {
        return $this->hasOne(Submission::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function (Acceptance $acceptance) {
            $acceptance->submission->removeAcceptance();
        });
    }
}
