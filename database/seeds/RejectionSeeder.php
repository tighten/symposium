<?php

use App\Rejection;
use App\Submission;
use Illuminate\Database\Seeder;

class RejectionSeeder extends Seeder
{
    public function run()
    {
        // randomly generate acceptances for submissions
        Submission::all()->filter(function($submission) {
            return ! $submission->isAccepted();
        })->each(function($submission) {
            if ((bool)mt_rand(0, 1)) {
                $rejection = factory(Rejection::class)->create([
                    'talk_revision_id' => $submission->talk_revision_id,
                    'conference_id' => $submission->conference_id,
                ]);
                $submission->recordRejection($rejection);
            }
        });
    }
}
