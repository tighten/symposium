<?php

namespace App\Http\Controllers;

use App\Models\Talk;

class DashboardController extends Controller
{
    public function index()
    {
        $talks = auth()->user()->talks->sortByTitle();

        $submissionsByConference = $talks->filter(function (Talk $talk) {
            return $talk->submissions()->exists();
        })->map(function ($talk) {
            return $talk->submissions()->with('conference')->get();
        })->flatten()->groupBy('conference_id');

        return view('dashboard', [
            'bios' => auth()->user()->bios,
            'submissionsByConference' => $submissionsByConference,
            'talks' => $talks,
        ]);
    }
}
