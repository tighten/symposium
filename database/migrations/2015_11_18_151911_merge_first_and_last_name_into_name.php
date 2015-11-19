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
            $table->string('name');
        });

        $this->populateNameColumn();

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
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
            $table->string('first_name');
            $table->string('last_name');
        });
    }

    /**
     * Populate the name column for all users
     *
     * @return void
     */
    private function populateNameColumn()
    {
        User::all()->each(function ($user) {
            $user->name = $user->first_name . ' ' . $user->last_name;
            $user->save();
        });
    }
}
