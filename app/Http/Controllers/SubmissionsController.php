<?php namespace Symposium\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Submission;
use Talk;
use Symposium\Commands\CreateSubmission;
use Symposium\Commands\DestroySubmission;

class SubmissionsController extends Controller
{
    public function store(Request $request)
    {
        $talk = Auth::user()->talks()->findOrFail($request->get('talkId'));

        $this->dispatch(new CreateSubmission(
            $request->get('conferenceId'),
            $talk->id
        ));

        return Response::json(['status' => 'success', 'message' => 'Talk Submitted']);
    }

    public function destroy(Request $request)
    {
        $talk = Auth::user()->talks()->findOrFail($request->get('talkId'));

        $this->dispatch(new DestroySubmission(
            $request->get('conferenceId'),
            $talk->id
        ));

        return Response::json(['status' => 'success', 'message' => 'Talk Un-Submitted']);
    }

    public function patch(Request $request) {
        $talk = Talk::findOrFail($request->get('talkId'));
        $talkRevisionIds = $talk->revisions->lists('id');

        $submission = Submission::where('conference_id', $request->get('conferenceId'))
            ->wherein('talk_revision_id', $talkRevisionIds)
            ->firstOrFail();

        $submission->joindin_url = $request->get('joindin');
        $submission->save();

        return Response::json(['status' => 'success', 'message' => 'Submission updated.']);
    }
}
