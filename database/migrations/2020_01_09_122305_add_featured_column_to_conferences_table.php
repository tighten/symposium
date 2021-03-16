<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeaturedColumnToConferencesTable extends Migration
{
    public function up()
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->boolean('featured')->after('author_id')->default(0);
        });
    }

    public function down()
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dropColumn('featured');
        });
    }
}
