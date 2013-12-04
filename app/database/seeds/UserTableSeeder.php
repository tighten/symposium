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
			),
			array(
				'email' => 'support@opengastro.com', // not quite
				'password' => Hash::make('magical password for non-real user that no one will ever guess'),
				'first_name' => 'Peter',
				'last_name' => 'Sziebig'
			),
			array(
				'email' => 'brett@brettterpstra.com', // No idea
				'password' => Hash::make('magical password for non-real user that no one will ever guess'),
				'first_name' => 'Brett',
				'last_name' => 'Terpstra'
			),
			array(
				'email' => 'jonathan@candlerblog.com', // No idea
				'password' => Hash::make('magical password for non-real user that no one will ever guess'),
				'first_name' => 'Jonathan',
				'last_name' => 'Poritsky'
			),
		));
	}
}
