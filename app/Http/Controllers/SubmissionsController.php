<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commands\CreateSubmission;
use App\Commands\DestroySubmission;
use App\Commands\ConvertToAcceptance;

class SubmissionsController extends Controller
{
    public function store(Request $request)
    {
        $talk = auth()->user()->talks()->findOrFail($request->input('talkId'));

        $this->dispatch(new CreateSubmission(
            $request->input('conferenceId'),
            $talk->id
        ));

        return response()->json(['status' => 'success', 'message' => 'Talk Submitted']);
    }

    public function update(Request $request)
    {
        $talk = auth()->user()->talks()->findOrFail($request->input('talkId'));

        $this->dispatch(new ConvertToAcceptance(
            $request->input('conferenceId'),
            $talk->id
        ));

        return response()->json(['status' => 'success', 'message' => 'Talk Accepted!']);
    }

    public function destroy(Request $request)
    {
        $talk = auth()->user()->talks()->findOrFail($request->input('talkId'));

        $this->dispatch(new DestroySubmission(
            $request->input('conferenceId'),
            $talk->id
        ));

        return response()->json(['status' => 'success', 'message' => 'Talk Un-Submitted']);
    }
}
