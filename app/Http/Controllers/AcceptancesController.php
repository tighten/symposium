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

        $acceptance = Acceptance::createFromSubmission($submission);

        $submission->recordAcceptance($acceptance);

        return response()->json(['status' => 'success', 'message' => 'Talk Accepted!']);
    }
}
