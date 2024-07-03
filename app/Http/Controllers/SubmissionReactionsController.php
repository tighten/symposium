<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\RedirectResponse;

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
