<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('talk_revisions', function (Blueprint $table) {
            $table->foreign('talk_id')->references('id')->on('talks')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::table('talk_revisions', function (Blueprint $table) {
            $table->dropForeign('talk_revisions_talk_id_foreign');
        });
    }
};
