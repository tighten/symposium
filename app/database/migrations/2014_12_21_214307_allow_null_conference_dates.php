<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllowNullConferenceDates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE `conferences` MODIFY `starts_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'");
		DB::statement("ALTER TABLE `conferences` MODIFY `ends_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'");
		DB::statement("ALTER TABLE `conferences` MODIFY `cfp_starts_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'");
		DB::statement("ALTER TABLE `conferences` MODIFY `cfp_ends_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE `conferences` MODIFY `starts_at` DATETIME NOT NULL');
		DB::statement('ALTER TABLE `conferences` MODIFY `ends_at` DATETIME NOT NULL');
		DB::statement('ALTER TABLE `conferences` MODIFY `cfp_starts_at` DATETIME NOT NULL');
		DB::statement('ALTER TABLE `conferences` MODIFY `cfp_ends_at` DATETIME NOT NULL');
	}

}
