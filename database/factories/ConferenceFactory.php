<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConferenceFactory extends Factory
{
    public function definition()
    {
        return [
            'author_id' => User::factory(),
            'title' => 'Dummy Conference',
            'description' => $this->faker->sentence,
            'url' => $this->faker->url,
            'starts_at' => $this->faker->dateTimeBetween('+3 days', '+10 days'),
            'ends_at' => $this->faker->dateTimeBetween('+11 days', '+20 days'),
            'cfp_starts_at' => $this->faker->dateTimeBetween('-9 days', '-1 day'),
            'cfp_ends_at' => $this->faker->dateTimeBetween('+1 days', '+2 days'),
            'is_approved' => false,
        ];
    }

    public function closedCFP()
    {
        return $this->state([
            'cfp_starts_at' => $this->faker->dateTimeBetween('-9 days', '-4 day'),
            'cfp_ends_at' => $this->faker->dateTimeBetween('-3 days', '-1 days'),
        ]);
    }

    public function noCFPDates()
    {
        return $this->state([
            'cfp_starts_at' => null,
            'cfp_ends_at' => null,
        ]);
    }

    public function approved()
    {
        return $this->state([
            'is_approved' => true,
        ]);
    }

    public function notApproved()
    {
        return $this->state([
            'is_approved' => false,
        ]);
    }

    public function shared()
    {
        return $this->state([
            'is_shared' => true,
        ]);
    }

    public function notShared()
    {
        return $this->state([
            'is_shared' => false,
        ]);
    }

    public function author($author)
    {
        return $this->state([
            'author_id' => $author,
        ]);
    }
}
