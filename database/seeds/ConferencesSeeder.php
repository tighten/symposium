<?php

use App\Conference;
use Illuminate\Database\Seeder;

class ConferencesSeeder extends Seeder
{
    public function run()
    {
        Conference::truncate();

        $conference_names = collect([
            'MegaAwesomeCon',
            'SuperPHP',
            'ActiveRecordCon',
            'ConCon',
            'GoodJobFest',
            'TightenFest',
            'UltraMegaCon',
            'ArbysCon',
        ]);

        factory(App\Conference::class)->create([
            'title' => $conference_names->random(),
        ], 30);
    }
}
