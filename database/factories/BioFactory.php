<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\User;
use Illuminate\Support\Str;

class BioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Bio::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return \App\User::factory()->create()->id;
            },
            'nickname' => $this->faker->word,
            'body' => $this->faker->sentence(),
        ];
    }
}
