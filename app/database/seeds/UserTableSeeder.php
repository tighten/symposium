<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		User::create(array(
			'email' => 'matt@markedstyle.com',
			'password' => Hash::make('password')
		));
	}
}
