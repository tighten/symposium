<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        auth()->user()->load([
            'favoritedConferences',
            'submissions' => function ($query) {
                $query->whereNotRejected();
            },
            'submissions.conference',
            'submissions.acceptance',
        ]);

        return view('dashboard', [
            'conferences' => auth()->user()->favoritedConferences,
            'submissions' => auth()->user()->submissions,
        ]);
    }
}
