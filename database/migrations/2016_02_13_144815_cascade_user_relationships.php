<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CascadeUserRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talks', function(Blueprint $table) {
            $table->dropForeign('talks_author_id_foreign');
            $table->foreign('author_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });

        Schema::table('bios', function(Blueprint $table) {
            $table->dropForeign('bios_user_id_foreign');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });

        Schema::table('conferences', function(Blueprint $table) {
            $table->dropForeign('conferences_author_id_foreign');
            $table->foreign('author_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
