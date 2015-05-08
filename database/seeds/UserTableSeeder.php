<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        User::create([
            'email' => 'matt@savemyproposals.com',
            'password' => Hash::make('password'),
            'first_name' => 'Matt',
            'last_name' => 'Stauffer',
        ]);
    }
}
