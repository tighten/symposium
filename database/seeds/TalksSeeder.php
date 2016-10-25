<?php

use App\Models\Talk;
use App\Models\TalkRevision;
use App\Models\User;
use Illuminate\Database\Seeder;

class TalksSeeder extends Seeder
{
    public function run()
    {
        TalkRevision::truncate();
        Talk::truncate();

        $author = User::first();

        $greatTalk = $author->talks()->create([]);
        $terribleTalk = $author->talks()->create([]);

        $author->talks()->saveMany([$greatTalk, $terribleTalk]);

        $greatTalk->revisions()->create([
            'title' => 'My great talk',
            'description' => 'Description of the talk',
            'type' => 'seminar',
            'level' => 'intermediate',
            'length' => '45',
            'slides' => 'http://speakerdeck.com/mattstauffer/my-great-talk',
            'organizer_notes' => 'Organizer notes',
            'created_at' => '2013-11-29 15:54:41'
        ]);

        $greatTalk->revisions()->create([
            'title' => 'My awesome talk',
            'description' => 'Description of the talk',
            'type' => 'seminar',
            'level' => 'intermediate',
            'length' => '45',
            'slides' => 'http://speakerdeck.com/mattstauffer/my-awesome-talk',
            'organizer_notes' => 'Organizer notes',
            'created_at' => '2013-11-27 15:54:41'
        ]);

        $terribleTalk->revisions()->create([
            'title' => 'My awesome talk',
            'description' => 'Description of the talk',
            'type' => 'seminar',
            'level' => 'intermediate',
            'length' => '45',
            'slides' => 'http://speakerdeck.com/mattstauffer/my-awesome-talk',
            'organizer_notes' => 'Organizer notes',
            'created_at' => '2013-11-28 15:54:41'
        ]);

        // Add a talk for user 2 for testing purposes
        $author = User::find(2);

        $superTalk = $author->talks()->create([]);
        $spiffyTalk = $author->talks()->create([]);

        $author->talks()->saveMany([$superTalk, $spiffyTalk]);

        $superTalk->revisions()->create([
            'title' => 'My Super talk',
            'description' => 'Description of the talk',
            'type' => 'seminar',
            'level' => 'intermediate',
            'length' => '45',
            'slides' => 'http://speakerdeck.com/mattstauffer/my-super-talk',
            'organizer_notes' => 'Organizer notes',
            'created_at' => '2013-11-27 15:54:41'
        ]);

        $spiffyTalk->revisions()->create([
            'title' => 'My Spiffy talk',
            'description' => 'Description of the talk',
            'type' => 'seminar',
            'level' => 'intermediate',
            'length' => '45',
            'slides' => 'http://speakerdeck.com/mattstauffer/my-spiffy-talk',
            'organizer_notes' => 'Organizer notes',
            'created_at' => '2013-11-28 15:54:41'
        ]);
    }
}
