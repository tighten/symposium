<?php

namespace Database\Factories;

use App\Models\Talk;
use Illuminate\Database\Eloquent\Factories\Factory;

class TalkRevisionFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => 'My Awesome Title',
            'type' => 'lightning',
            'length' => '9',
            'level' => 'beginner',
            'slides' => 'http://speakerdeck.com/mattstauffer/the-best-talk-ever',
            'description' => 'The best talk ever!',
            'organizer_notes' => 'No really.',
            'talk_id' => Talk::factory(),
        ];
    }
}
