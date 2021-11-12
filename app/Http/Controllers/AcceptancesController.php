<?php

namespace App\Http\Controllers;

use App\Models\Acceptance;
use App\Models\Submission;
use Illuminate\Http\Request;

class AcceptancesController extends Controller
{
    public function store(Request $request)
    {
        $submission = Submission::findOrFail($request->input('submissionId'));
        if (auth()->user()->id != $submission->talkRevision->talk->author_id) {
            return response('', 401);
        }

        if ($submission->isRejected()) {
            return response('Cannot Accept a Rejected Submission', 403);
        }

        $acceptance = Acceptance::createFromSubmission($submission);

        return response()->json([
            'status' => 'success',
            'message' => 'Talk Accepted!',
            'acceptanceId' => $acceptance->id,
        ]);
    }

    public function destroy(Acceptance $acceptance)
    {
        if (auth()->user()->id != $acceptance->submission->talkRevision->talk->author_id) {
            return response('', 401);
        }

        $acceptance->delete();

        return response()->json(['status' => 'success', 'message' => 'Talk un-marked as accepted.']);
    }
}
