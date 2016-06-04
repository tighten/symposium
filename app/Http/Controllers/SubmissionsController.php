<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Commands\CreateSubmission;
use App\Commands\DestroySubmission;

class SubmissionsController extends Controller
{
    public function store(Request $request)
    {
        $talk = Auth::user()->talks()->findOrFail($request->get('talkId'));

        $this->dispatch(new CreateSubmission(
            $request->get('conferenceId'),
            $talk->id
        ));

        return Response::json(['status' => 'success', 'message' => 'Talk Submitted']);
    }

    public function destroy(Request $request)
    {
        $talk = Auth::user()->talks()->findOrFail($request->get('talkId'));

        $this->dispatch(new DestroySubmission(
            $request->get('conferenceId'),
            $talk->id
        ));

        return Response::json(['status' => 'success', 'message' => 'Talk Un-Submitted']);
    }
}
