<?php

use Carbon\Carbon;

$factory(\App\Conference::class, 'conference', [
    'author_id' => 1,
    'title' => 'Dummy Conference',
    'description' => 'A conference for dummies.',
    'url' => 'http://example.com',
    'starts_at' => Carbon::now()->addDays(10),
    'ends_at' => Carbon::now()->addDays(12),
    'cfp_starts_at' => Carbon::now()->subDays(2),
    'cfp_ends_at' => Carbon::now()->addDays(1),
]);

$factory(\App\Talk::class, 'talk', [
]);

$factory(App\TalkRevision::class, 'talkRevision', [
    'title' => 'My Awesome Title',
    'type' => 'lightning',
    'length' => '9',
    'level' => 'beginner',
    'slides' => 'http://speakerdeck.com/mattstauffer/the-best-talk-ever',
    'description' => 'The best talk ever!',
    'organizer_notes' => 'No really.',
]);

$factory(\App\User::class, 'user', [
    'email' => $faker->email,
    'password' => Hash::make('password'),
    'name' => 'Jane Doe',
]);

$factory(\App\Bio::class, 'bio', [
    'nickname' => 'short',
    'body' => 'Lorem ipsum datum',
]);
