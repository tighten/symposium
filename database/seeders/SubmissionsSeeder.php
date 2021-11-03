<?php

namespace Database\Seeders;

use App\Models\Conference;
use App\Models\Submission;
use App\Models\TalkRevision;
use Illuminate\Database\Seeder;

class SubmissionsSeeder extends Seeder
{
    public function run()
    {
        Conference::all()->each(function ($conference) {
            $talkRevisions = TalkRevision::inRandomOrder()->limit(mt_rand(1, 5))->get();
            $talkRevisions->each(function ($talkRevision) use ($conference) {
                Submission::factory()->create([
                    'talk_revision_id' => $talkRevision->id,
                    'conference_id' => $conference->id,
                ]);
            });
        });
    }
}
