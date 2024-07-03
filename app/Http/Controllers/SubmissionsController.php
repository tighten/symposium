<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Submission;
use App\Models\Talk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SubmissionsController extends Controller
{
    public function store(Request $request)
    {
        $talk = Talk::findOrFail($request->input('talkId'));
        if (auth()->user()->id != $talk->author_id) {
            return response('', 401);
        }

        $conference = Conference::findOrFail($request->input('conferenceId'));
        $talkRevision = $talk->loadCurrentRevision()->currentRevision;
        $submission = $conference->submissions()->create(['talk_revision_id' => $talkRevision->id]);

        return response()->json([
            'status' => 'success',
            'message' => 'Talk Submitted',
            'submissionId' => $submission->id,
        ]);
    }

    public function edit(Submission $submission): View
    {
        $submission->load([
            'acceptance',
            'rejection',
            'reactions',
        ]);

        return view('submissions.edit', [
            'submission' => $submission,
            'conference' => $submission->conference,
        ]);
    }

    public function update(Submission $submission, Request $request)
    {
        if (auth()->user()->id != $submission->talkRevision->talk->author_id) {
            return response('', 401);
        }

        request()->validate([
            'response' => [
                'required',
                Rule::in(array_keys(Submission::RESPONSES)),
            ],
            'reason' => 'nullable|max:255',
        ]);

        $response = $submission->firstOrCreateResponse($request->input('response'));

        $response->reason = $request->input('reason');
        $response->save();

        Session::flash('success-message', 'Successfully updated submission.');

        return redirect()->route('talks.show', $submission->talkRevision->talk);
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
