<?php namespace App\ApiResources;

use App\Talk as EloquentTalk;
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
            'title' => $this->talk->current()->title,
            'description' => $this->talk->current()->description,
            'type' => $this->talk->current()->type,
            'length' => $this->talk->current()->length,
            'level' => $this->talk->current()->level,
            'slides' => $this->talk->current()->slides,
            'public' => $this->talk->public,
            'organizer_notes' => $this->talk->current()->organizer_notes,
            'created_at' => (string)$this->talk->current()->created_at,
            'updated_at' => (string)$this->talk->current()->updated_at,
        ];
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'type' => $this->getType(),
            'attributes' => $this->attributes()
        ];
    }
}
