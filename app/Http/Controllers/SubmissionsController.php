<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commands\CreateSubmission;
use App\Commands\DestroySubmission;

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
