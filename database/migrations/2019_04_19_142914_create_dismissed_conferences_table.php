<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDismissedConferencesTable extends Migration
{
    public function up()
    {
        Schema::create('dismissed_conferences', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index('dismissed_conferences_user_id_foreign');
            $table->string('conference_id', 36)->index('dismissed_conferences_conference_id_foreign');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('dismissed_conferences');
    }
}
