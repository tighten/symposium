<?php namespace App\Commands;

use App\Conference;
use App\Talk;

class CreateSubmission extends Command
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
