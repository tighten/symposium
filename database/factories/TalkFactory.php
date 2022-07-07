<?php

namespace Database\Factories;

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

    public function author($author)
    {
        return $this->for($author, 'author');
    }

    public function archived()
    {
        return $this->state([
            'is_archived' => true,
        ]);
    }
}
