<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CfpClosingEventResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => "cfp-closing-{$this->id}",
            'title' => "CFPs close for {$this->title}",
            'start' => $this->cfp_ends_at,
            'end' => $this->cfp_ends_at,
            'url' => route('conferences.show', $this->id),
            'type' => 'cfp-closing',
        ];
    }
}
