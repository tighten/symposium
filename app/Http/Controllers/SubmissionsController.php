<?php

namespace App\Http\Controllers;

use App\Conference;
use App\Submission;
use Illuminate\Http\Request;

class SubmissionsController extends Controller
{
    public function store(Request $request)
    {
        $talkRevision = auth()->user()->talks()->findOrFail($request->input('talkId'))->current();
        $conference = Conference::findOrFail($request->input('conferenceId'));

        $submission = $conference->submissions()->create(['talk_revision_id' => $talkRevision->id]);

        return response()->json([
            'status' => 'success',
            'message' => 'Talk Submitted',
            'submissionId' => $submission->id
        ]);
    }

    public function destroy($id)
    {
        $submission = Submission::findOrFail($id);
        $userHasAccess = auth()->user()->talks->filter(function ($talk) use ($submission) {
            return $talk->talkRevision === $submission->talkRevision;
        }) !== false;

        if (!$userHasAccess) {
            throw new Exception("Not Authorized");
        }
        $submission->delete();

        return response()->json(['status' => 'success', 'message' => 'Talk Un-Submitted']);
    }
}
