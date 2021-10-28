<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::truncate();

        \App\User::factory()->create([
            'name' => 'Matt Stauffer',
            'email' => 'matt@savemyproposals.com',
        ]);

        \App\User::factory()->create([
            'is_featured' => rand(0, 1),
        ], 10);
    }
}
