<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllowNullCfpDates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('conferences', function(Blueprint $table)
		{
			$table->dateTime('cfp_starts_at')->nullable()->change();
			$table->dateTime('cfp_ends_at')->nullable()->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('conferences', function(Blueprint $table)
		{
			$table->dateTime('cfp_starts_at')->default('0000-00-00')->change();
			$table->dateTime('cfp_ends_at')->default('0000-00-00')->change();
		});
	}

}
