<?php namespace App\ApiResources;

use App\Conference as EloquentConference;
use Illuminate\Contracts\Support\Arrayable;

class Conference implements Arrayable
{
    private $conference;

    public function __construct(EloquentConference $conference)
    {
        $this->conference = $conference;
    }

    public function getId()
    {
        return $this->conference->id;
    }

    public function getType()
    {
        return 'conferences';
    }

    public function attributes()
    {
        return [
            'title' => $this->conference->title,
            'description' => $this->conference->description,
            'url' => $this->conference->url,
            'cfp_url' => $this->conference->cfp_url,
            'starts_at' => (string)$this->conference->starts_at,
            'ends_at' => (string)$this->conference->ends_at,
            'cfp_starts_at' => (string)$this->conference->cfp_starts_at,
            'cfp_ends_at' => (string)$this->conference->cfp_ends_at,
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
