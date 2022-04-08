<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->string('rejection_id', 36)->nullable()->index('submissions_rejection_id_foreign');
        });
    }

    public function down()
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn('rejection_id');
        });
    }
};
