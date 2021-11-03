<?php

namespace Database\Factories;

use App\Models\Bio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BioFactory extends Factory
{
    protected $model = Bio::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'nickname' => $this->faker->word,
            'body' => $this->faker->sentence(),
        ];
    }
}
