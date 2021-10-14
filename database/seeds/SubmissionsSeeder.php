<?php

use App\Conference;
use App\Submission;
use App\TalkRevision;
use Illuminate\Database\Seeder;

class SubmissionsSeeder extends Seeder
{
    public function run()
    {
        Conference::all()->each(function($conference) {
            $talkRevisions = TalkRevision::inRandomOrder()->limit(mt_rand(1, 5))->get();
            $talkRevisions->each(function($talkRevision) use ($conference) {
                factory(Submission::class)->create([
                    'talk_revision_id' => $talkRevision->id,
                    'conference_id' => $conference->id,
                ]);
            });
        });
    }
}
