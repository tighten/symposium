<?php

namespace App\Http\Controllers;

use App\Acceptance;
use App\Submission;
use Illuminate\Http\Request;

class AcceptancesController extends Controller
{
    public function store(Request $request)
    {
        $submission = Submission::findOrFail($request->input('submissionId'));
        $userHasAccess = auth()->user()->talks->filter(function ($talk) use ($submission) {
            return $talk->talkRevision === $submission->talkRevision;
        }) !== false;

        if (!$userHasAccess) {
            throw new Exception("Not Authorized");
        }

        $acceptance = Acceptance::createFromSubmission($submission);

        return response()->json([
            'status' => 'success',
            'message' => 'Talk Accepted!',
            'acceptanceId' => $acceptance->id,
        ]);
    }

    public function destroy($id)
    {
        $acceptance = Acceptance::findOrFail($id);
        $userHasAccess = auth()->user()->talks->filter(function ($talk) use ($acceptance) {
            return $talk->talkRevision === $acceptance->talkRevision;
        }) !== false;

        if (!$userHasAccess) {
            throw new Exception("Not Authorized");
        }

        $acceptance->submission->removeAcceptance();
        $acceptance->delete();

        return response()->json(['status' => 'success', 'message' => 'Talk Moved back to Submitted Status']);
    }
}
