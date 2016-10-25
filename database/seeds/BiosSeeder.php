<?php

use App\Models\Bio;
use App\Models\User;
use Illuminate\Database\Seeder;

class BiosSeeder extends Seeder
{
    public function run()
    {
        Bio::truncate();

        $author = User::first();

        $shortBio = $author->bios()->create(['nickname' => 'Short Bio', 'body' => 'I am short.']);
        $longBio = $author->bios()->create(['nickname' => 'Long Bio', 'body' => 'I am short and I love being short and this is very long.']);

        $author->bios()->saveMany([$shortBio, $longBio]);

        // Add a talk for user 2 for testing purposes
        $author = User::find(2);

        $trueBio = $author->bios()->create(['nickname' => 'True Bio', 'body' => 'I am a person.']);
        $falseBio = $author->bios()->create(['nickname' => 'False Bio', 'body' => 'I am an elephant.']);

        $author->bios()->saveMany([$trueBio, $falseBio]);
    }
}
