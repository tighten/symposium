<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionReactionsController extends Controller
{
    public function store(Request $request, Submission $submission)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $submission->addReaction(request('url'));
    }
}
