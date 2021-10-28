<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\User;
use Illuminate\Support\Str;

class TalkRevisionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\TalkRevision::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
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
            'talk_id' => function () {
                return \App\Talk::factory()->create()->id;
            },
        ];
    }
}
