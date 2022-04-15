<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up()
    {
        Schema::table('bios', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down()
    {
        Schema::table('bios', function (Blueprint $table) {
            $table->dropForeign('bios_user_id_foreign');
        });
    }
};
