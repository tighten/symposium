<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Conference;
use App\Models\ConferenceIssue;
use Illuminate\Validation\Rule;

class ConferenceIssuesController extends Controller
{
    public function create(Conference $conference): View
    {
        return view('conferences.issues.create', [
            'conference' => $conference,
            'reasonOptions' => ConferenceIssue::reasonOptions(),
        ]);
    }

    public function store(Conference $conference): RedirectResponse
    {
        request()->validate([
            'reason' => [
                'required',
                Rule::in(ConferenceIssue::REASONS),
            ],
            'note' => 'required',
        ]);

        $conference->reportIssue(
            request('reason'),
            request('note'),
            auth()->user(),
        );

        return redirect()->route('conferences.show', $conference)
            ->with(['success-message' => 'Thank you for reporting this issue!']);
    }
}
