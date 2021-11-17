<?php

namespace App\Http\Controllers;

use App\Models\Rejection;

class RejectionController extends Controller
{
    public function destroy(Rejection $rejection)
    {
        if (auth()->user()->id != $rejection->submission->talkRevision->talk->author_id) {
            return response('', 401);
        }

        $rejection->delete();

        return response()->json(['status' => 'success', 'message' => 'Talk un-marked as rejected.']);
    }
}
