<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FleshOutConferences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('conferences', function(Blueprint $table) {
        // 	$table->dateTime('starts_at')->nullable()->default(null);
        // 	$table->dateTime('ends_at')->nullable()->default(null);
        // 	$table->dateTime('cfp_starts_at')->nullable()->default(null);
        // 	$table->dateTime('cfp_ends_at')->nullable()->default(null);
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
        // 	$table->dropColumn('starts_at');
        // 	$table->dropColumn('ends_at');
        // 	$table->dropColumn('cfp_starts_at');
        // 	$table->dropColumn('cfp_ends_at');
        // });
    }
}
