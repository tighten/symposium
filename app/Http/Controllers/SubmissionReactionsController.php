<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\Submission;

class SubmissionReactionsController extends Controller
{
    public function store(Submission $submission): RedirectResponse
    {
        request()->validate([
            'url' => 'required|url',
        ]);

        $submission->addReaction(request('url'));

        return redirect()->route('submission.edit', $submission);
    }
}
