<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveOutline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('talk_revisions', function (Blueprint $table) {
        //     $table->dropColumn('outline');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('talk_revisions', function (Blueprint $table) {
        //     $table->text('outline')->nullable();
        // });
    }
}
