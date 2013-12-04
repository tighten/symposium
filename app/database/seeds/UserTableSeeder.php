<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->truncate();

		DB::table('users')->insert(array(
			array(
				'email' => 'matt@markedstyle.com',
				'password' => Hash::make('password'),
				'first_name' => 'Matt',
				'last_name' => 'Stauffer'
			),
			array(
				'email' => 'info@atelierbramdehaan.nl',
				'password' => Hash::make('magical password for non-real user that no one will ever guess'),
				'first_name' => 'Bram',
				'last_name' => 'de Haan'
			)
		));
	}
}
