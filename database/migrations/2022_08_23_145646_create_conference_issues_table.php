<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('conference_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('conference_id');
            $table->string('reason');
            $table->text('note');
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conference_issues');
    }
};
