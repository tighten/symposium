<?php

namespace Database\Factories;

use App\Models\Conference;
use App\Models\Talk;
use App\Models\TalkRevision;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TalkFactory extends Factory
{
    public function definition()
    {
        return [
            'author_id' => User::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Talk $talk) {
            TalkRevision::factory()->for($talk)->create();
        });
    }

    public function author($author)
    {
        return $this->for($author, 'author');
    }

    public function submitted()
    {
        return $this->afterCreating(function (Talk $talk) {
            Conference::factory()->received($talk->current())->create();
        });
    }
}
