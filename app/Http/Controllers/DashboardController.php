<?php

namespace App\Http\Controllers;

use App\Talk;

class DashboardController extends Controller
{
    public function index()
    {
        $talks = auth()->user()->talks->sortBy(function (Talk $talk) {
            return strtolower($talk->current()->title);
        });

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
