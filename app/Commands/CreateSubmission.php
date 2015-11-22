<?php namespace Symposium\Commands;

use Conference;
use Symposium\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use TalkRevision;

class CreateSubmission extends Command implements SelfHandling
{
	private $conferenceId;
	private $talkRevisionId;

	public function __construct($conferenceId, $talkRevisionId)
	{
		$this->conferenceId = $conferenceId;
		$this->talkRevisionId = $talkRevisionId;
	}

	public function handle()
	{
		$conference = Conference::findOrFail($this->conferenceId);
		$talkRevision = TalkRevision::findOrFail($this->talkRevisionId);
		$conference->submissions()->save($talkRevision, [
			'status' => 'submitted'
		]);
	}
}
