<?php

namespace App\Http\Controllers;

use App\Models\Submission;

class SubmissionReactionsController extends Controller
{
    public function store(Submission $submission)
    {
        $submission->addReaction(request('url'));
    }
}
