<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up()
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->foreign('conference_id')->references('id')->on('conferences')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropForeign('favorites_conference_id_foreign');
            $table->dropForeign('favorites_user_id_foreign');
        });
    }
};
