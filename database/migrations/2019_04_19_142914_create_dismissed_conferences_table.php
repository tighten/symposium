<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dismissed_conferences', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index('dismissed_conferences_user_id_foreign');
            $table->string('conference_id', 36)->index('dismissed_conferences_conference_id_foreign');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('dismissed_conferences');
    }
};
