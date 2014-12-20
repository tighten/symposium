<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->truncate();

		DB::table('users')->insert(array(
			array(
				'email' => 'matt@savemyproposals.com',
				'password' => Hash::make(Str::random()),
				'first_name' => 'Matt',
				'last_name' => 'Stauffer',
				'twitter' => 'stauffermatt',
				'url' => 'http://mattstauffer.co/'
			)
		));
	}
}
