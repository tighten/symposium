<?php

namespace App\Http\Controllers;

use App\Rejection;
use App\Submission;
use Illuminate\Http\Request;

class RejectionController extends Controller
{
    public function store(Request $request)
    {
        $submission = Submission::findOrFail($request->input('submissionId'));
        if (auth()->user()->id != $submission->talkRevision->talk->author_id) {
            return response('', 401);
        }

        $rejection = Rejection::createFromSubmission($submission);

        return response()->json([
            'status' => 'success',
            'message' => 'Talk Rejected',
            'rejectionId' => $rejection->id,
        ]);
    }

    public function destroy(Rejection $rejection)
    {
        if (auth()->user()->id != $rejection->submission->talkRevision->talk->author_id) {
            return response('', 401);
        }

        $rejection->delete();

        return response()->json(['status' => 'success', 'message' => 'Talk un-marked as rejected.']);
    }
}
