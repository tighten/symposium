<?php namespace Symposium\ApiResources;

use Bio as EloquentBio;

class Bio
{
    private $bio;

    public function __construct(EloquentBio $bio)
    {
        $this->bio = $bio;
    }

    public function getId()
    {
        return $this->bio->id;
    }

    public function getType()
    {
        return 'bios';
    }

    public function attributes()
    {
        return [
            'nickname' => $this->bio->nickname,
            'body' => $this->bio->body,
            'created_at' => (string)$this->bio->created_at,
            'updated_at' => (string)$this->bio->updated_at,
        ];
    }
}
