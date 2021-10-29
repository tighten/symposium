<?php

namespace Database\Factories;

use App\Acceptance;
use App\Conference;
use App\TalkRevision;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcceptanceFactory extends Factory
{
    protected $model = Acceptance::class;

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
