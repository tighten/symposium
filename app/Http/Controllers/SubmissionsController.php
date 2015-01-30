<?php namespace SaveMyProposals\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use SaveMyProposals\Commands\CreateSubmission;
use SaveMyProposals\Commands\DestroySubmission;
use SaveMyProposals\Http\Requests;

use Illuminate\Http\Request;

class SubmissionsController extends Controller
{
    public function store()
    {
        $conferenceId = Input::get('conferenceId');
        $talkVersionRevisionId = Input::get('talkVersionRevisionId');

        $this->dispatch(new CreateSubmission($conferenceId, $talkVersionRevisionId));

        return Response::json(['status' => 'success', 'message' => 'Talk Submitted']);
    }

    public function destroy()
    {
        $conferenceId = Input::get('conferenceId');
        $talkVersionRevisionId = Input::get('talkVersionRevisionId');

        $this->dispatch(new DestroySubmission($conferenceId, $talkVersionRevisionId));

        return Response::json(['status' => 'success', 'message' => 'Talk Un-Submitted']);
    }
}
