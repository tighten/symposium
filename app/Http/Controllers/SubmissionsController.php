<?php

namespace App\Http\Controllers;

use App\Models\Acceptance;
use App\Models\Conference;
use App\Models\Submission;
use App\Models\Talk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    public function update(Submission $submission, Request $request)
    {
        if (auth()->user()->id != $submission->talkRevision->talk->author_id) {
            return response('', 401);
        }

        $validator = Validator::make($request->only('response', 'reason'), [
            'response' => [
                'required',
                Rule::in(array_keys(Submission::RESPONSES)),
            ],
            'reason' => 'nullable|max:255',
        ]);

        if ($validator->passes()) {
            $response = (Submission::RESPONSES[$request->input('response')])::createFromSubmission($submission);

            $response->reason = $request->input('reason');
            $response->save();

            Session::flash('success-message', 'Successfully updated submission.');

            return redirect('conferences/' . $submission->conference->id);
        }

        return redirect(route('submission.update', $submission))
            ->withErrors($validator)
            ->withInput();
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
