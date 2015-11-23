<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UuidizeTalksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('talks', function (Blueprint $table) {
        //     $table->dropColumn('id');
        //     // $table->dropUnique('talks_id_unique');
        // });

        // Schema::table('talks', function (Blueprint $table) {
        //     $table->string('id', 36)->after('title')->unique()->default(0);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('talks', function (Blueprint $table) {
        //     $table->dropUnique('talks_id_unique');
        //     $table->dropColumn('id');
        // });

        // Schema::table('talks', function (Blueprint $table) {
        //     $table->increments('id');
        //     // $table->unique('title');
        // });
    }
}
