<?php namespace Symposium\Commands;

use Conference;
use Symposium\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use TalkRevision;

class CreateSubmission extends Command implements SelfHandling {
	/**
	 * @var string
	 */
	private $conferenceId;
	/**
	 * @var string
	 */
	private $talkRevisionId;

	/**
	 * Create a new command instance.
	 */
	public function __construct($conferenceId, $talkRevisionId)
	{
		$this->conferenceId = $conferenceId;
		$this->talkRevisionId = $talkRevisionId;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$conference = Conference::findOrFail($this->conferenceId);
		$$talkRevision = TalkRevision::findOrFail($this->talkRevisionId);
		$conference->submissions()->save($$talkRevision);
	}

}
