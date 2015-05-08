<?php

use Illuminate\Database\Seeder;

class TalksSeeder extends Seeder
{
    public function run()
    {
        TalkVersionRevision::truncate();
        TalkVersion::truncate();
        Talk::truncate();

        $author = User::first();

        $greatTalk = $author->talks()->create(['title' => 'My Great Talk', 'description' => 'Description of the talk']);
        $terribleTalk = $author->talks()->create(['title' => 'My Terrible Talk', 'description' => 'Description of the talk']);

        $author->talks()->saveMany([$greatTalk, $terribleTalk]);

        $greatTalkVersion1 = $greatTalk->versions()->create(['nickname' => 'php conf version', 'created_at' => '2013-11-27 15:54:41']);
        $greatTalkVersion2 = $greatTalk->versions()->create(['nickname' => 'frontend conf version', 'created_at' => '2013-11-28 15:54:41']);

        $greatTalkVersion1->revisions()->create([
            'title' => 'My great talk',
            'description' => 'Description of the talk',
            'type' => 'seminar',
            'level' => 'intermediate',
            'length' => '45',
            'outline' => 'Talk outline',
            'organizer_notes' => 'Organizer notes',
            'created_at' => '2013-11-29 15:54:41'
        ]);

        $greatTalkVersion1->revisions()->create([
            'title' => 'My awesome talk',
            'description' => 'Description of the talk',
            'type' => 'seminar',
            'level' => 'intermediate',
            'length' => '45',
            'outline' => 'Talk outline',
            'organizer_notes' => 'Organizer notes',
            'created_at' => '2013-11-27 15:54:41'
        ]);

        $greatTalkVersion2->revisions()->create([
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
