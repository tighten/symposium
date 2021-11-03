<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConferenceEventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start' => $this->starts_at,
            'end' => $this->ends_at,
            'url' => route('conferences.show', $this->id),
            'type' => 'conference',
        ];
    }
}
