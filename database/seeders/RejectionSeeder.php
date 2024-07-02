<?php

namespace Database\Seeders;

use App\Models\Rejection;
use App\Models\Submission;
use Illuminate\Database\Seeder;

class RejectionSeeder extends Seeder
{
    public function run(): void
    {
        Submission::all()->filter(function ($submission) {
            return ! $submission->isAccepted();
        })->each(function ($submission) {
            if (mt_rand(0, 1)) {
                $rejection = Rejection::factory()->create([
                    'talk_revision_id' => $submission->talk_revision_id,
                    'conference_id' => $submission->conference_id,
                ]);
                $submission->recordRejection($rejection);
            }
        });
    }
}
