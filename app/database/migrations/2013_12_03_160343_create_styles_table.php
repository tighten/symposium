<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStylesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('styles', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title')->unique();
			$table->string('slug')->unique();
			$table->text('description');
			$table->text('source');
			$table->enum('format', array('css', 'sass', 'scss'));
			$table->integer('author_id')->unsigned();
			// Not going to do InnoDB so we can use EngineHosting/ArcusTech
			// $table->foreign('author')
				// ->references('id')
				// ->on('users');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('styles');
	}
}
