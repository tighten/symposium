<?php namespace Symposium\ApiResources;

use Talk as EloquentTalk;

class Talk
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
            'outline' => $this->talk->current()->outline,
            'organizer_notes' => $this->talk->current()->organizer_notes,
            'created_at' => (string)$this->talk->current()->created_at,
            'updated_at' => (string)$this->talk->current()->updated_at,
        ];
    }
}
