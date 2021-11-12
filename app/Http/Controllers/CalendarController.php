<?php

namespace App\Http\Controllers;

use App\Http\Resources\CalendarEventCollection;
use App\Models\Conference;
use Carbon\Carbon;

class CalendarController extends BaseController
{
    public function index()
    {
        return view('calendar', [
            'events' => CalendarEventCollection::make([])
                ->addConferences(Conference::approved()->whereAfter(Carbon::now()->subYear())->whereHasDates()->get())
                ->addCfpOpenings(Conference::approved()->whereAfter(Carbon::now()->subYear())->whereHasCfpStart()->get())
                ->addCfpClosings(Conference::approved()->whereAfter(Carbon::now()->subYear())->whereHasCfpEnd()->get())
                ->toJson(),
        ]);
    }
}
