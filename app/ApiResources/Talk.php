<?php

namespace App\ApiResources;

use App\Models\Talk as EloquentTalk;
use Illuminate\Contracts\Support\Arrayable;

class Talk implements Arrayable
{
    private $talk;

    public function __construct(EloquentTalk $talk)
    {
        $this->talk = $talk;
    }

    public function getId()
    {
        return $this->talk->id;
    }

    public function getType()
    {
        return 'talks';
    }

    public function attributes()
    {
        return [
            'title' => $this->talk->currentRevision->title,
            'description' => $this->talk->currentRevision->description,
            'type' => $this->talk->currentRevision->type,
            'length' => $this->talk->currentRevision->length,
            'level' => $this->talk->currentRevision->level,
            'slides' => $this->talk->currentRevision->slides,
            'public' => $this->talk->public,
            'organizer_notes' => $this->talk->currentRevision->organizer_notes,
            'created_at' => (string) $this->talk->currentRevision->created_at,
            'updated_at' => (string) $this->talk->currentRevision->updated_at,
        ];
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'type' => $this->getType(),
            'attributes' => $this->attributes(),
        ];
    }
}
