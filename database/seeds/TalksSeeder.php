<?php

use Illuminate\Database\Seeder;

class TalksSeeder extends Seeder
{
    public function run()
    {
        TalkRevision::truncate();
        Talk::truncate();

        $author = User::first();

        $greatTalk = $author->talks()->create();
        $terribleTalk = $author->talks()->create();

        $author->talks()->saveMany([$greatTalk, $terribleTalk]);

        $greatTalk->revisions()->create([
            'title' => 'My great talk',
            'description' => 'Description of the talk',
            'type' => 'seminar',
            'level' => 'intermediate',
            'length' => '45',
            'outline' => 'Talk outline',
            'organizer_notes' => 'Organizer notes',
            'created_at' => '2013-11-29 15:54:41'
        ]);

        $greatTalk->revisions()->create([
            'title' => 'My awesome talk',
            'description' => 'Description of the talk',
            'type' => 'seminar',
            'level' => 'intermediate',
            'length' => '45',
            'outline' => 'Talk outline',
            'organizer_notes' => 'Organizer notes',
            'created_at' => '2013-11-27 15:54:41'
        ]);

        $terribleTalk->revisions()->create([
            'title' => 'My awesome talk',
            'description' => 'Description of the talk',
            'type' => 'seminar',
            'level' => 'intermediate',
            'length' => '45',
            'outline' => 'Talk outline',
            'organizer_notes' => 'Organizer notes',
            'created_at' => '2013-11-28 15:54:41'
        ]);
    }
}
