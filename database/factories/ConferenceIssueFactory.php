<?php

namespace Database\Factories;

use App\Models\Conference;
use App\Models\ConferenceIssue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ConferenceIssueFactory extends Factory
{
    public function definition()
    {
        return [
            'conference_id' => Conference::factory(),
            'reason' => Arr::random(ConferenceIssue::REASONS),
            'note' => $this->faker->sentence,
        ];
    }

    public function closed()
    {
        return $this->state(function () {
            return [
                'closed_at' => $this->faker->dateTime,
            ];
        });
    }
}
