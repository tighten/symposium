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
		// @todo can we do with ALTER instead?
		DB::statement("ALTER TABLE `conferences` MODIFY `starts_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'");
		DB::statement("ALTER TABLE `conferences` MODIFY `ends_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'");
		DB::statement("ALTER TABLE `conferences` MODIFY `cfp_starts_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'");
		DB::statement("ALTER TABLE `conferences` MODIFY `cfp_ends_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'");

//		Schema::table('conferences', function(Blueprint $table) {
//			$table->dropColumn('starts_at');
//			$table->dropColumn('ends_at');
//			$table->dropColumn('cfp_starts_at');
//			$table->dropColumn('cfp_ends_at');
//		});
//
//		Schema::table('conferences', function(Blueprint $table) {
//			$table->datetime('starts_at')->nullable();
//			$table->datetime('ends_at')->nullable();
//			$table->datetime('cfp_starts_at')->nullable();
//			$table->datetime('cfp_ends_at')->nullable();
//		});
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

//		Schema::table('conferences', function(Blueprint $table) {
//			$table->dropColumn('starts_at');
//			$table->dropColumn('ends_at');
//			$table->dropColumn('cfp_starts_at');
//			$table->dropColumn('cfp_ends_at');
//		});
//
//		Schema::table('conferences', function(Blueprint $table) {
//			$table->dateTime('starts_at');
//			$table->dateTime('ends_at');
//			$table->dateTime('cfp_starts_at');
//			$table->dateTime('cfp_ends_at');
//		});
	}

}
