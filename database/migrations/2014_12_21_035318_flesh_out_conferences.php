<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FleshOutConferences extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('conferences', function(Blueprint $table) {
			$table->dateTime('starts_at')->default('0000-00-00');
			$table->dateTime('ends_at')->default('0000-00-00');
			$table->dateTime('cfp_starts_at')->default('0000-00-00');
			$table->dateTime('cfp_ends_at')->default('0000-00-00');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('conferences', function(Blueprint $table) {
			$table->dropColumn('starts_at');
			$table->dropColumn('ends_at');
			$table->dropColumn('cfp_starts_at');
			$table->dropColumn('cfp_ends_at');
		});
	}

}
