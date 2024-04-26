<?php

namespace Database\Factories;

use App\Models\Conference;
use App\Models\Talk;
use App\Models\TalkRevision;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

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
            $this->revise($talk);
        });
    }

    public function archived()
    {
        return $this->state([
            'is_archived' => true,
        ]);
    }

    public function author(User $user)
    {
        return $this->for($user, 'author');
    }

    public function submitted()
    {
        return $this->afterCreating(function (Talk $talk) {
            Conference::factory()->received($talk->currentRevision())->create();
        });
    }

    public function revised(array $revisions)
    {
        return $this->afterCreating(function (Talk $talk) use ($revisions) {
            $this->revise(
                $talk,
                array_merge(['created_at' => Carbon::now()], $revisions),
            );
        });
    }

    private function revise(Talk $talk, $attributes = [])
    {
        TalkRevision::factory()->for($talk)->create($attributes);
    }
}
