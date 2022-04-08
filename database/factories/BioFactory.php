<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BioFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'nickname' => $this->faker->word(),
            'body' => $this->faker->sentence(),
        ];
    }

    public function public()
    {
        return $this->state([
            'public' => true,
        ]);
    }

    public function private()
    {
        return $this->state([
            'public' => false,
        ]);
    }
}
