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

        factory(App\User::class)->create([], 10);
    }
}
