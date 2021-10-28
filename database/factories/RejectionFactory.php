<?php

namespace Database\Factories;

use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RejectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Rejection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'talk_revision_id' => function () {
                return \App\TalkRevision::factory()->create()->id;
            },
            'conference_id' => function () {
                return \App\Conference::factory()->create()->id;
            },
        ];
    }
}
