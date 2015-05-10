<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        User::truncate();

        User::create([
            'email' => 'matt@savemyproposals.com',
            'password' => Hash::make('password'),
            'first_name' => 'Matt',
            'last_name' => 'Stauffer',
        ]);
    }
}
