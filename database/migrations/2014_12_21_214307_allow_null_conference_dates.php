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
		/**
		 * This change was merged into the `flesh_out_conferences` migration to simplify
		 * testing with SQLite.
		 *
		 * This migration file is left here just because it is listed as "ran" in production,
		 * and this will prevent weird errors should we for some bizarre reason ever have to
		 * rollback this far.
		 */

		// DB::statement("ALTER TABLE `conferences` MODIFY `starts_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'");
		// DB::statement("ALTER TABLE `conferences` MODIFY `ends_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'");
		// DB::statement("ALTER TABLE `conferences` MODIFY `cfp_starts_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'");
		// DB::statement("ALTER TABLE `conferences` MODIFY `cfp_ends_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// DB::statement('ALTER TABLE `conferences` MODIFY `starts_at` DATETIME NOT NULL');
		// DB::statement('ALTER TABLE `conferences` MODIFY `ends_at` DATETIME NOT NULL');
		// DB::statement('ALTER TABLE `conferences` MODIFY `cfp_starts_at` DATETIME NOT NULL');
		// DB::statement('ALTER TABLE `conferences` MODIFY `cfp_ends_at` DATETIME NOT NULL');
	}

}
