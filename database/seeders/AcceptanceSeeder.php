<?php

namespace Database\Seeders;

use App\Models\Acceptance;
use App\Models\Submission;
use Illuminate\Database\Seeder;

class AcceptanceSeeder extends Seeder
{
    public function run(): void
    {
        Submission::all()->each(function ($submission) {
            if (mt_rand(0, 1)) {
                $acceptance = Acceptance::factory()->create([
                    'talk_revision_id' => $submission->talk_revision_id,
                    'conference_id' => $submission->conference_id,
                ]);
                $submission->recordAcceptance($acceptance);
            }
        });
    }
}
