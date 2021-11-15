<?php

namespace Database\Factories;

use App\Models\Conference;
use App\Models\TalkRevision;
use Illuminate\Database\Eloquent\Factories\Factory;

class RejectionFactory extends Factory
{
    public function definition()
    {
        return [
            'talk_revision_id' => function () {
                return TalkRevision::factory()->create()->id;
            },
            'conference_id' => function () {
                return Conference::factory()->create()->id;
            },
        ];
    }
}
