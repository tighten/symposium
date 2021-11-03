<?php

namespace App\Http\Resources;

use App\Http\Resources\CfpClosingEventResource;
use App\Http\Resources\CfpOpeningEventResource;
use App\Http\Resources\ConferenceEventResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CalendarEventCollection extends ResourceCollection
{
    public function addConferences($conferences)
    {
        return $this->addEvents(ConferenceEventResource::collection($conferences));
    }

    public function addCfpOpenings($conferences)
    {
        return $this->addEvents(CfpOpeningEventResource::collection($conferences));
    }

    public function addCfpClosings($conferences)
    {
        return $this->addEvents(CfpClosingEventResource::collection($conferences));
    }

    private function addEvents($events)
    {
        $this->collection = $this->collection->concat($events->collection->values());

        return $this;
    }
}
