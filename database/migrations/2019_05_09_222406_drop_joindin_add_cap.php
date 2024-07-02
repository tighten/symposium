<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Drops the joindin_id column from the conferences table and replaces
 * it with a calling_all_papers_id column.  Data loss will ensue.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dropColumn('joindin_id');
        });
        Schema::table('conferences', function (Blueprint $table) {
            $table->string('calling_all_papers_id', 40)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dropColumn('calling_all_papers_id');
        });
        Schema::table('conferences', function (Blueprint $table) {
            $table->integer('joindin_id')->nullable();
        });
    }
};
