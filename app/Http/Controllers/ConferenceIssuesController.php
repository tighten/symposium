<?php

namespace App\Http\Controllers;

use App\Models\Conference;

class ConferenceIssuesController extends Controller
{
    public function create(Conference $conference)
    {
        return view('conferences.issues.create', [
            'conference' => $conference,
        ]);
    }

    public function store(Conference $conference)
    {
        request()->validate([
            'reason' => 'required',
            'note' => 'required',
        ]);

        $conference->reportIssue(
            request('reason'),
            request('note'),
        );

        return redirect()
            ->route('conferences.show', $conference)
            ->with(['success-message' => 'Thank you for reporting this issue!']);
    }
}
