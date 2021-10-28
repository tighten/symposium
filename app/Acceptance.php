<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Acceptance extends UuidBase
{
    use HasFactory;

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
        $acceptance = self::create([
            'talk_revision_id' => $submission->talkRevision->id,
            'conference_id' => $submission->conference->id,
        ]);

        $submission->recordAcceptance($acceptance);

        return $acceptance;
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function (self $acceptance) {
            $acceptance->submission->removeAcceptance();
        });
    }

    public function submission()
    {
        return $this->hasOne(Submission::class);
    }
}
