<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTalksTable extends Migration {
	public function up()
	{
		Schema::create('talks', function(Blueprint $table)
		{
			$table->string('id', 36)->default('0')->unique();
			$table->integer('author_id')->unsigned()->index('talks_author_id_foreign');
			$table->timestamps();
			$table->boolean('public')->default(0);
			$table->boolean('is_archived')->default(0);
		});
	}

	public function down()
	{
		Schema::drop('talks');
	}

}
