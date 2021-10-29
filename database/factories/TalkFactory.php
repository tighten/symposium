<?php

namespace Database\Factories;

use App\Talk;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TalkFactory extends Factory
{
    protected $model = Talk::class;

    public function definition()
    {
        return [
            'author_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
