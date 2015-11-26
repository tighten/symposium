<?php namespace Symposium\ApiResources;

use Bio as EloquentBio;
use Illuminate\Contracts\Support\Arrayable;

class Bio implements Arrayable
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
            'public' => $this->bio->public,
            'body' => $this->bio->body,
            'created_at' => (string)$this->bio->created_at,
            'updated_at' => (string)$this->bio->updated_at,
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
