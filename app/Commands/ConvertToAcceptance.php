<?php

namespace App\Commands;

use App\Conference;
use App\Talk;

class ConvertToAcceptance extends Command
{
    private $conferenceId;
    private $talkId;

    public function __construct($conferenceId, $talkId)
    {
        $this->conferenceId = $conferenceId;
        $this->talkId = $talkId;
    }

    public function handle()
    {
        $conference = Conference::findOrFail($this->conferenceId);
        $talk = Talk::findOrFail($this->talkId);

        $revisionIds = $talk->revisions->pluck('id');
        $talkRevision = $conference->submissions()
            ->whereIn('talk_revision_id', $revisionIds)
            ->firstOrFail();

        $conference->submissions()->detach($talkRevision);

        $conference->acceptances()->save($talk->current());
    }
}
