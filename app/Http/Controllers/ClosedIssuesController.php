<?php

namespace App\Http\Controllers;

use App\Models\ConferenceIssue;
use Illuminate\Validation\ValidationException;

class ClosedIssuesController extends Controller
{
    public function store(ConferenceIssue $issue)
    {
        throw_if($issue->closed_at, ValidationException::withMessages([
            'issue' => ['This issue has already been closed.'],
        ]));

        $issue->closed_at = now();
        $issue->save();

        return redirect()->route('conferences.show', $issue->conference);
    }
}
