<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('talk_revision_id', 36);
            $table->string('conference_id', 36)->index('submissions_conference_id_foreign');
            $table->timestamps();
            $table->string('acceptance_id', 36)->nullable()->index('submissions_acceptance_id_foreign');
            $table->unique(['talk_revision_id', 'conference_id'], 'submissions_talk_revision_conference_unique');
        });
    }

    public function down()
    {
        Schema::drop('submissions');
    }
};
