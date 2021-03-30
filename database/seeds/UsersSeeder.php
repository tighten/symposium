<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::truncate();

        factory(App\User::class)->create([
            'name' => 'Matt Stauffer',
            'email' => 'matt@savemyproposals.com',
        ]);

        factory(App\User::class)->create([
            'is_featured' => rand(0, 1),
        ], 10);
    }
}
