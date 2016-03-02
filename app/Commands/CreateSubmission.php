<?php namespace Symposium\Commands;

use Conference;
use Symposium\Commands\Command;
use Talk;
use TalkRevision;

class CreateSubmission extends Command implements
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
        $conference->submissions()->save($talk->current(), [
            'status' => 'submitted'
        ]);
    }
}
