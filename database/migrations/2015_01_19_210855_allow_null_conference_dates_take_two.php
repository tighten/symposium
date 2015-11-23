<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllowNullConferenceDatesTakeTwo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/**
		 * This change was merged into flesh_out_conferences
		 */
		// Schema::table('conferences', function(Blueprint $table)
		// {
			// $table->dateTime('starts_at')->nullable()->default(null)->change();
			// $table->dateTime('ends_at')->nullable()->default(null)->change();
			// $table->dateTime('cfp_starts_at')->nullable()->default(null)->change();
			// $table->dateTime('cfp_ends_at')->nullable()->default(null)->change();
		// });

		// foreach (['starts_at', 'ends_at', 'cfp_starts_at', 'cfp_ends_at'] as $col) {
		// 	DB::table('conferences')->where($col, '0000-00-00 00:00')->update([$col => null]);
		// }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Schema::table('conferences', function(Blueprint $table)
		// {
			// $table->dateTime('starts_at')->default('0000-00-00')->change();
			// $table->dateTime('ends_at')->default('0000-00-00')->change();
			// $table->dateTime('cfp_starts_at')->default('0000-00-00')->change();
			// $table->dateTime('cfp_ends_at')->default('0000-00-00')->change();
		// });

		// foreach (['starts_at', 'ends_at', 'cfp_starts_at', 'cfp_ends_at'] as $col) {
		// 	DB::table('conferences')->where($col, null)->update([$col => '0000-00-00 00:00']);
		// }
	}

}
