<?php

namespace Database\Factories;

use App\Models\Acceptance;
use App\Models\Conference;
use App\Models\Rejection;
use App\Models\Submission;
use App\Models\TalkRevision;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubmissionFactory extends Factory
{
    public function definition()
    {
        return [
            'talk_revision_id' => TalkRevision::factory(),
            'conference_id' => Conference::factory(),
        ];
    }

    public function accepted()
    {
        return $this->afterCreating(function (Submission $submission) {
            $acceptance = Acceptance::factory()
                ->for($submission->talkRevision)
                ->for($submission->conference)
                ->create();

            $submission->acceptance_id = $acceptance->id;
            $submission->save();
        });
    }

    public function rejected()
    {
        return $this->afterCreating(function (Submission $submission) {
            $rejection = Rejection::factory()
                ->for($submission->talkRevision)
                ->for($submission->conference)
                ->create();

            $submission->rejection_id = $rejection->id;
            $submission->save();
        });
    }
}
