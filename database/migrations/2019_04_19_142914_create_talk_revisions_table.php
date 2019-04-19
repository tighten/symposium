<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTalkRevisionsTable extends Migration
{
    public function up()
    {
        Schema::create('talk_revisions', function (Blueprint $table) {
            $table->string('id', 36)->unique('talk_version_revisions_id_unique');
            $table->string('title');
            $table->string('type', 50);
            $table->integer('length');
            $table->enum('level', ['beginner','intermediate','advanced']);
            $table->text('description', 65535);
            $table->string('slides')->nullable();
            $table->text('organizer_notes', 65535);
            $table->timestamps();
            $table->string('talk_id', 36)->default('')->index('talk_revisions_talk_id_foreign');
        });
    }

    public function down()
    {
        Schema::drop('talk_revisions');
    }
}
