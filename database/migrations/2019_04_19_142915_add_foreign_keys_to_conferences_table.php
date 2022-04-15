<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up()
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down()
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dropForeign('conferences_author_id_foreign');
        });
    }
};
