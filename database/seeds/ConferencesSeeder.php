<?php

use App\Models\Conference;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory;

class ConferencesSeeder extends Seeder
{
    public function run()
    {
        Conference::truncate();

        $faker = Faker::create();
        $user_ids = collect(User::lists('id'));
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

        foreach (range(1, 30) as $i) {
            $starts_at = $faker->dateTimeBetween('now', '3 years');
            $cfp_starts_at = $faker->dateTimeBetween('now', $starts_at);

            Factory::create('conference', [
                'author_id' => $user_ids->random(),
                'title' => $conference_names->random() . " {$starts_at->format('Y')}",
                'description' => $faker->sentence,
                'starts_at' => $starts_at,
                'ends_at' => Carbon::instance($starts_at)->addDays(2),
                'cfp_starts_at' => $cfp_starts_at,
                'cfp_ends_at' => Carbon::instance($cfp_starts_at)->addDays(rand(15, 30)),
            ]);
        }
    }
}
