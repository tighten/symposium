<?php

namespace App\Http\Controllers;

use App\Conference;
use App\Http\Resources\CalendarEventCollection;

class CalendarController extends BaseController
{
    public function index()
    {
        return view('calendar', [
            'events' => CalendarEventCollection::make([])
                ->addConferences(Conference::approved()->whereHasDates()->get())
                ->addCfpOpenings(Conference::approved()->whereHasCfpStart()->get())
                ->addCfpClosings(Conference::approved()->whereHasCfpEnd()->get())
                ->toJson(),
        ]);
    }
}
