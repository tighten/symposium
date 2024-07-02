<?php

use App\Models\Conference;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conference_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Conference::class)->constrained();
            $table->unsignedInteger('user_id')->constrained();
            $table->string('reason');
            $table->text('note');
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conference_issues');
    }
};
