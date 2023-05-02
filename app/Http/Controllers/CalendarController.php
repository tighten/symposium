<?php

namespace App\Http\Controllers;

use App\Http\Resources\CalendarEventCollection;
use App\Models\Conference;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar', [
            'events' => CalendarEventCollection::make([])
                ->addConferences($this->query()->whereHasDates()->get())
                ->addCfpOpenings($this->query()->whereHasCfpStart()->get())
                ->addCfpClosings($this->query()->whereHasCfpEnd()->get())
                ->toJson(),
        ]);
    }

    private function query()
    {
        return Conference::query()
            ->approved()
            ->whereNotDismissedBy(auth()->user())
            ->whereAfter(Carbon::now()->subYear());
    }
}
