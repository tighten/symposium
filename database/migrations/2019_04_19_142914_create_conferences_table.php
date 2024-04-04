<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('conferences', function (Blueprint $table) {
            $table->string('id', 36)->unique();
            $table->string('title');
            $table->text('description', 65535);
            $table->string('url');
            $table->integer('author_id')->unsigned()->index('conferences_author_id_foreign');
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->dateTime('cfp_starts_at')->nullable();
            $table->dateTime('cfp_ends_at')->nullable();
            $table->integer('joindin_id')->nullable();
            $table->timestamps();
            $table->string('cfp_url')->nullable();
            $table->boolean('is_approved')->default(0);
            $table->boolean('is_shared')->default(0);
        });
    }

    public function down(): void
    {
        Schema::drop('conferences');
    }
};
