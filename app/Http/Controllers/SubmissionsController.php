<?php namespace Symposium\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Symposium\Commands\CreateSubmission;
use Symposium\Commands\DestroySubmission;
use Symposium\Http\Requests;

use Illuminate\Http\Request;

class SubmissionsController extends Controller
{
    public function store()
    {
        $conferenceId = Input::get('conferenceId');
        $talkRevisionId = Input::get('talkRevisionId');

        $this->dispatch(new CreateSubmission($conferenceId, $talkRevisionId));

        return Response::json(['status' => 'success', 'message' => 'Talk Submitted']);
    }

    public function destroy()
    {
        $conferenceId = Input::get('conferenceId');
        $talkRevisionId = Input::get('talkRevisionId');

        $this->dispatch(new DestroySubmission($conferenceId, $talkRevisionId));

        return Response::json(['status' => 'success', 'message' => 'Talk Un-Submitted']);
    }
}
