<?php

namespace App\Http\Controllers;

use App\Conference;
use Calendar;

class CalendarController extends BaseController
{
    public function index()
    {
        $calendar = Calendar::addEvents($this->conferenceEvents())
            ->addEvents($this->cfpStartEvents())
            ->addEvents($this->cfpEndEvents());

        return view('calendar', [
            'calendar' => $calendar,
            'options' => $calendar->getOptionsJson(),
        ]);
    }

    private function conferenceEvents()
    {
        return Conference::all()->reject(function ($conference) {
            return $conference->startsAtSet() === null || $conference->endsAtSet() === null;
        })->map(function ($conference) {
            return Calendar::event(
                $conference->title,
                true,
                $conference->starts_at,
                $conference->ends_at,
                $conference->id,
                [
                    'color' => '#428bca',
                    'url' => route('conferences.show', $conference->id),
                ]
            );
        })->toArray();
    }

    private function cfpStartEvents()
    {
        return Conference::all()->reject(function (Conference $conference) {
            return $conference->cfpStartsAtSet() === null;
        })->map(function ($conference) {
            return Calendar::event(
                "CFPs open for {$conference->title}",
                true,
                $conference->cfp_starts_at,
                $conference->cfp_starts_at,
                'cfp-' . $conference->id,
                [
                    'color' => '#F39C12',
                    'url' => route('conferences.show', $conference->id),
                ]
            );
        })->toArray();
    }

    private function cfpEndEvents()
    {
        return Conference::all()->reject(function (Conference $conference) {
            return $conference->cfpEndsAtSet() === null;
        })->map(function ($conference) {
            return Calendar::event(
                "CFPs close for {$conference->title}",
                true,
                $conference->cfp_ends_at,
                $conference->cfp_ends_at,
                'cfp-' . $conference->id,
                [
                    'color' => '#E74C3C',
                    'url' => route('conferences.show', $conference->id),
                ]
            );
        })->toArray();
    }
}
