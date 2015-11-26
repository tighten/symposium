<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublicProfileFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_slug')->nullable();
            $table->boolean('enable_profile')->default(false);
            $table->boolean('allow_profile_contact')->default(false);
            $table->text('profile_intro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Why separate schema calls? Friggin SQlite.
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_slug');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_intro');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('enable_profile');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('allow_profile_contact');
        });
    }
}
