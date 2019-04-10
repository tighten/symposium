<?php

namespace App\Http\Controllers;

use App\Talk;
use Illuminate\Database\Eloquent\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $talks = auth()->user()->talks->sortBy(function (Talk $talk) {
            return strtolower($talk->current()->title);
        });
        /** @var Collection $talks */

        $submittedTalks = $talks->filter(function (Talk $talk) {
            return $talk->submissions()->exists();
        });
        $submissionsByConference = [];
        foreach ($submittedTalks as $submittedTalk) {
            foreach ($submittedTalk->submissions as $submission) {
                $conferenceId = $submission->conference->id;
                $submissionsByConference[$conferenceId][] = $submission;
            }
        }

        return view('dashboard', [
            'bios' => auth()->user()->bios,
            'submissionsByConference' => $submissionsByConference,
            'talks' => $talks,
        ]);
    }
}
