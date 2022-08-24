<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\ConferenceIssue;
use Illuminate\Validation\Rule;

class ConferenceIssuesController extends Controller
{
    public function create(Conference $conference)
    {
        return view('conferences.issues.create', [
            'conference' => $conference,
            'reasonOptions' => ConferenceIssue::reasonOptions(),
        ]);
    }

    public function store(Conference $conference)
    {
        request()->validate([
            'reason' => [
                'required',
                Rule::in(ConferenceIssue::REASONS),
            ],
            'note' => 'required',
        ]);

        $conference->reportIssue(request('reason'), request('note'));

        return redirect()->route('conferences.show', $conference)
            ->with(['success-message' => 'Thank you for reporting this issue!']);
    }

    public function show(ConferenceIssue $issue)
    {
        return view('conferences.issues.show', [
            'issue' => $issue,
        ]);
    }
}
