<?php

namespace App\Http\Controllers;

use App\Conference;
use Calendar;

class CalendarController extends BaseController
{
    public function index()
    {
        $calendar = Calendar::addEvents(Conference::all()->map(function($conference) {
            return \Calendar::event(
                $conference->title,
                false,
                $conference->starts_at,
                $conference->ends_at,
                $conference->id
            );
        })->toArray());

        return view('calendar', [
            'calendar' => $calendar,
            'options' => $calendar->getOptionsJson(),
        ]);
    }
}
