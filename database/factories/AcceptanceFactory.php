<?php

namespace Database\Factories;

use App\Models\Conference;
use App\Models\TalkRevision;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcceptanceFactory extends Factory
{
    public function definition()
    {
        return [
            'talk_revision_id' => TalkRevision::factory(),
            'conference_id' => Conference::factory(),
        ];
    }
}
