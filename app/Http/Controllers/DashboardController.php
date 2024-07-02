<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        auth()->user()->load([
            'favoritedConferences' => fn ($query) => $query->future(),
            'submissions' => function ($query) {
                $query->whereNotRejected()->whereFuture();
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
