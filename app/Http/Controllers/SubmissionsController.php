<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Submission;
use App\Models\Talk;
use Illuminate\Http\Request;

class SubmissionsController extends Controller
{
    public function store(Request $request)
    {
        $talk = Talk::findOrFail($request->input('talkId'));
        if (auth()->user()->id != $talk->author_id) {
            return response('', 401);
        }

        $conference = Conference::findOrFail($request->input('conferenceId'));
        $talkRevision = $talk->current();
        $submission = $conference->submissions()->create(['talk_revision_id' => $talkRevision->id]);

        return response()->json([
            'status' => 'success',
            'message' => 'Talk Submitted',
            'submissionId' => $submission->id,
        ]);
    }

    public function destroy(Submission $submission)
    {
        if (auth()->user()->id != $submission->talkRevision->talk->author_id) {
            return response('', 401);
        }
        $submission->delete();

        return response()->json(['status' => 'success', 'message' => 'Talk Un-Submitted']);
    }
}
