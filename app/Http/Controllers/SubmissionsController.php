<?php

namespace App\Http\Controllers;

use App\Conference;
use App\Submission;
use Illuminate\Http\Request;

class SubmissionsController extends Controller
{
    public function store(Request $request)
    {
        $talk = auth()->user()->talks()->findOrFail($request->input('talkId'))->current();
        $conference = Conference::findOrFail($request->input('conferenceId'));

        $submission = Submission::create([
            'conference_id' => $conference->id,
            'talk_revision_id' => $talk->id
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Talk Submitted',
            'submissionId' => $submission->id
        ]);
    }

    public function destroy($id)
    {
        Submission::destroy($id);

        return response()->json(['status' => 'success', 'message' => 'Talk Un-Submitted']);
    }
}
