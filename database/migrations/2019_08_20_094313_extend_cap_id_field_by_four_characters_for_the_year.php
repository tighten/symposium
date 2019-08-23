<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendCapIdFieldByFourCharactersForTheYear extends Migration
{
    public function up()
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->string('calling_all_papers_id', 44)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->string('calling_all_papers_id', 40)->nullable()->change();
        });
    }
}
