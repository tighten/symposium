<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BioFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'nickname' => $this->faker->word,
            'body' => $this->faker->sentence(),
        ];
    }
}
