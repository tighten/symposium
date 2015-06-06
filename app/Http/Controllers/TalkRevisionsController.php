<?php namespace Symposium\Http\Controllers;

use Auth;
use Log;
use Redirect;
use Session;
use Talk;
use TalkRevision;
use View;

class TalkRevisionsController extends BaseController
{
    public function __construct()
    {
        $this->beforeFilter(
            'auth'
        );
    }

    public function show($talkId, $revisionId)
    {
        $talk = Auth::user()->talks()->findOrFail($talkId);
        $revision = $talk->revisions()->findOrFail($revisionId);

        return View::make('talks.show')
            ->with('talk', $talk)
            ->with('current', $revision);
    }
}
