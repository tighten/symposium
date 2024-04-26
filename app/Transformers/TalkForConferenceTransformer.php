<?php

namespace App\Transformers;

use App\Models\Conference;
use App\Models\Talk;

class TalkForConferenceTransformer
{
    public static function transform(Talk $talk, Conference $conference)
    {
        $currentTalk = $talk->currentRevision();

        $submission = $talk->getMySubmissionForConference($conference);
        $acceptance = $submission ? $submission->acceptance : null;
        $rejection = $submission ? $submission->rejection : null;

        return [
            'id' => $talk->id,
            'title' => $currentTalk->title,
            'url' => $currentTalk->getUrl(),
            'submitted' => (bool) $submission,
            'submissionId' => $submission ? $submission->id : null,
            'accepted' =>  (bool) $acceptance,
            'acceptanceId' => $acceptance ? $acceptance->id : null,
            'rejected' =>  (bool) $rejection,
            'rejectionId' => $rejection ? $rejection->id : null,
        ];
    }
}
