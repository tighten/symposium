<?php

namespace App\Models;

use App\Models\Conference;
use App\Models\TalkRevision;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rejection extends UuidBase
{
    use HasFactory;

    protected $table = 'rejections';

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
        $rejection = self::create([
            'talk_revision_id' => $submission->talkRevision->id,
            'conference_id' => $submission->conference->id,
        ]);

        $submission->recordRejection($rejection);

        return $rejection;
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function (self $rejection) {
            $rejection->submission->removeRejection();
        });
    }

    public function submission()
    {
        return $this->hasOne(Submission::class);
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }

    public function talkRevision()
    {
        return $this->belongsTo(TalkRevision::class);
    }
}
