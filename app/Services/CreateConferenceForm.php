<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\Conference;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;

class CreateConferenceForm
{
    private $rules = [
        'title' => ['required'],
        'description' => ['required'],
        'url' => ['required', 'url'],
        'cfp_url' => ['nullable', 'url'],
        'location' => [],
        'starts_at' => ['nullable', 'date'],
        'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        'cfp_starts_at' => ['nullable', 'date', 'before:starts_at'],
        'cfp_ends_at' => ['nullable', 'date', 'after:cfp_starts_at', 'before:starts_at'],
        'latitude' => ['nullable'],
        'longitude' => ['nullable'],
    ];

    private $input;
    private $user;

    private function __construct($input, $user)
    {
        $this->input = $input;
        $this->user = $user;
    }

    public static function fillOut($input, $user)
    {
        return new self($input, $user);
    }

    public function complete()
    {
        $validation = Validator::make($this->input, $this->rules);

        if ($validation->fails()) {
            throw new ValidationException('Invalid input provided, see errors', $validation->errors());
        }

        $conference = Conference::create(array_merge($validation->validated(), [
            'author_id' => $this->user->id,
        ]));
        Event::dispatch('new-conference', [$conference]);

        return $conference;
    }
}
