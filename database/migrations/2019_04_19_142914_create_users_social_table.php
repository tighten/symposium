<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersSocialTable extends Migration {
	public function up()
	{
		Schema::create('users_social', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('users_social_user_id_foreign');
			$table->string('social_id');
			$table->string('service');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('users_social');
	}

}
