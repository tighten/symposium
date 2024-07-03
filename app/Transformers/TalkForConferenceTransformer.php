<?php

namespace App\Transformers;

use App\Models\Conference;
use App\Models\Talk;

class TalkForConferenceTransformer
{
    public static function transform(Talk $talk, Conference $conference)
    {
        $currentRevision = $talk->currentRevision;
        $currentRevision->setRelation('talk', $talk);

        $submission = $talk->getMySubmissionForConference($conference);
        $acceptance = $submission ? $submission->acceptance : null;
        $rejection = $submission ? $submission->rejection : null;

        return [
            'id' => $talk->id,
            'title' => $currentRevision->title,
            'url' => $currentRevision->getUrl(),
            'submitted' => (bool) $submission,
            'submissionId' => $submission ? $submission->id : null,
            'accepted' => (bool) $acceptance,
            'acceptanceId' => $acceptance ? $acceptance->id : null,
            'rejected' => (bool) $rejection,
            'rejectionId' => $rejection ? $rejection->id : null,
        ];
    }
}
