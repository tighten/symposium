<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::truncate();
        $faker = Faker::create();

        User::create([
            'email' => 'matt@savemyproposals.com',
            'password' => Hash::make('password'),
            'first_name' => 'Matt',
            'last_name' => 'Stauffer',
        ]);

        foreach (range(1, 10) as $i) {
            Factory::create('user', [
                'email' => $faker->email,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
            ]);
        }
    }
}
