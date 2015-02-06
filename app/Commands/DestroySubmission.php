<?php namespace Symposium\Commands;

use Conference;
use Symposium\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use TalkVersionRevision;

class DestroySubmission extends Command implements SelfHandling {

	/**
	 * @var string
	 */
	private $conferenceId;
	/**
	 * @var string
	 */
	private $talkVersionRevisionId;

	/**
	 * Create a new command instance.
	 */
	public function __construct($conferenceId, $talkVersionRevisionId)
	{
		$this->conferenceId = $conferenceId;
		$this->talkVersionRevisionId = $talkVersionRevisionId;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$conference = Conference::findOrFail($this->conferenceId);
		$talkVersionRevision = TalkVersionRevision::findOrFail($this->talkVersionRevisionId);
		$conference->submissions()->detach($talkVersionRevision);
	}

}
