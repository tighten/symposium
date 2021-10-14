<?php

use App\Acceptance;
use App\Submission;
use Illuminate\Database\Seeder;

class AcceptanceSeeder extends Seeder
{
    public function run()
    {
        Submission::all()->each(function($submission) {
            if (mt_rand(0, 1)) {
                $acceptance = factory(Acceptance::class)->create([
                    'talk_revision_id' => $submission->talk_revision_id,
                    'conference_id' => $submission->conference_id,
                ]);
                $submission->recordAcceptance($acceptance);
            }
        });
    }
}
