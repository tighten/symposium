<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::truncate();

        User::factory()->create([
            'name' => 'Matt Stauffer',
            'email' => 'matt@savemyproposals.com',
        ]);

        User::factory()->times(10)->create([
            'is_featured' => rand(0, 1),
        ]);
    }
}
