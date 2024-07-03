<?php

namespace Database\Seeders;

use App\Models\Conference;
use Illuminate\Database\Seeder;

class ConferencesSeeder extends Seeder
{
    public function run(): void
    {
        Conference::truncate();

        $conferenceNames = collect([
            'MegaAwesomeCon',
            'SuperPHP',
            'ActiveRecordCon',
            'ConCon',
            'GoodJobFest',
            'TightenFest',
            'UltraMegaCon',
            'ArbysCon',
            'TightenCon',
            'LiveTightenStuff',
            'SuperTightenYay',
        ]);

        foreach ($conferenceNames as $name) {
            Conference::factory()->create([
                'title' => $name,
                'is_featured' => rand(0, 1),
                'is_approved' => true,
            ]);
        }
    }
}
