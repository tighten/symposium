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
        'starts_at' => ['date'],
        'ends_at' => ['date', 'after_or_equal:starts_at'],
        'cfp_starts_at' => ['date', 'before:starts_at'],
        'cfp_ends_at' => ['date', 'after:cfp_starts_at', 'before:starts_at'],
        'latitude' => ['nullable'],
        'longitude' => ['nullable'],
    ];

    private $input;
    private $user;

    private function __construct($input, $user)
    {
        $this->input = $input;
        $this->user = $user;
        $this->guardAdminFields();
        $this->removeEmptyFields();
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

    private function guardAdminFields()
    {
        if (! $this->user->isAdmin()) {
            unset($this->input['is_approved']);
            unset($this->input['is_shared']);
        }
    }

    private function removeEmptyFields()
    {
        $this->input = array_filter($this->input);
    }
}
