<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MergeFirstAndLastNameIntoName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable();
        });

        // Drop columns must be separate because SQLite ¯\(°_o)/¯
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
        });
    }
}
