<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('talks', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down(): void
    {
        Schema::table('talks', function (Blueprint $table) {
            $table->dropForeign('talks_author_id_foreign');
        });
    }
};
