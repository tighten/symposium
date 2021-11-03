<?php

namespace Database\Factories;

use App\Models\Talk;
use App\Models\User;
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
