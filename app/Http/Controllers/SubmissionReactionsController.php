<?php

namespace App\Http\Controllers;

use App\Models\Submission;

class SubmissionReactionsController extends Controller
{
    public function store(Submission $submission)
    {
        request()->validate([
            'url' => 'required|url',
        ]);

        $submission->addReaction(request('url'));

        return redirect()->route('submission.edit', $submission);
    }
}
