<?php

namespace App\Http\Controllers;

use App\Models\Acceptance;
use App\Models\Submission;
use Illuminate\Http\Request;

class AcceptancesController extends Controller
{
    public function destroy(Acceptance $acceptance)
    {
        if (auth()->user()->id != $acceptance->submission->talkRevision->talk->author_id) {
            return response('', 401);
        }

        $acceptance->delete();

        return response()->json(['status' => 'success', 'message' => 'Talk un-marked as accepted.']);
    }
}
