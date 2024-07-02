<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('acceptances', function (Blueprint $table) {
            $table->foreign('conference_id')->references('id')->on('conferences')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('talk_revision_id')->references('id')->on('talk_revisions')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::table('acceptances', function (Blueprint $table) {
            $table->dropForeign('acceptances_conference_id_foreign');
            $table->dropForeign('acceptances_talk_revision_id_foreign');
        });
    }
};
