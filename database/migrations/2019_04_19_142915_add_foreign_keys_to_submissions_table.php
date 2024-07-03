<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->foreign('acceptance_id')->references('id')->on('acceptances')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('conference_id')->references('id')->on('conferences')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('talk_revision_id')->references('id')->on('talk_revisions')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeign('submissions_acceptance_id_foreign');
            $table->dropForeign('submissions_conference_id_foreign');
            $table->dropForeign('submissions_talk_revision_id_foreign');
        });
    }
};
