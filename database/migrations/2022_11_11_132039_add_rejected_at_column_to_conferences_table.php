<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dateTime('rejected_at')->after('cfp_ends_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dropColumn('rejected_at');
        });
    }
};
