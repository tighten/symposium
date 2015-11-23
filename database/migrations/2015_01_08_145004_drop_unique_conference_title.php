<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropUniqueConferenceTitle extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Schema::table('conferences', function(Blueprint $table) {
		// 	$table->dropUnique('conferences_title_unique');
		// });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Schema::table('conferences', function(Blueprint $table) {
		// 	$table->unique('title');
		// });
	}

}
