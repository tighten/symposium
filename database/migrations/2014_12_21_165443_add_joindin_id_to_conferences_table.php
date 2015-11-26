<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJoindinIdToConferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('conferences', function(Blueprint $table) {
        // 	$table->integer('joindin_id')->nullable();
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
        // 	$table->dropColumn('joindin_id');
        // });
    }
}
