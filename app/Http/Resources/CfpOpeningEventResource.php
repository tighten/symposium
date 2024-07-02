<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CfpOpeningEventResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => "cfp-opening-{$this->id}",
            'title' => "CFPs open for {$this->title}",
            'start' => $this->cfp_starts_at,
            'end' => $this->cfp_starts_at,
            'url' => route('conferences.show', $this->id),
            'type' => 'cfp-opening',
        ];
    }
}
