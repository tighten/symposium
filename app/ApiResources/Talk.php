<?php namespace Symposium\ApiResources;

class Talk
{
    public $type = 'talks';
    public $id;


    public $created_at;
    public $updated_at;

    public function __construct(Talk $talk)
    {
        $this->talk = $talk;
    }

    public function attributes()
    {
        return [
            "title": "",
            "description": "",
            "created_at": "",
            "updated_at": "",
            "type": "",
            "length": "",
            "level": "",
            "outline": "",
            "organizer_notes": "",
        ];
    }
}
