<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->string('location')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
        });
    }

    public function down()
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dropColumn('location');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }
};
