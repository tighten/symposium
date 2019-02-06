<?php

namespace App\Transformers;

use App\Conference;
use App\Talk;

class TalkForConferenceTransformer
{
    public static function transform(Talk $talk, Conference $conference)
    {
        /** @var Talk $currentTalk */
        $currentTalk = $talk->current();

        $submission = $talk->getMySubmissionForConference($conference);
        $acceptance = $submission ? $submission->acceptance : null;

        return [
            'id' => $talk->id,
            'title' => $currentTalk->title,
            'url' => $currentTalk->getUrl(),
            'submitted' => $acceptance ? false : !!$submission,
            'submissionId' => $submission ? $submission->id : null,
            'accepted' =>  !!$acceptance,
            'acceptanceId' => $acceptance ? $acceptance->id : null
        ];
    }
}
