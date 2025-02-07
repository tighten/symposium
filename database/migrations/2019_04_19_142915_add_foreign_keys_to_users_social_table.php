<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users_social', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::table('users_social', function (Blueprint $table) {
            $table->dropForeign('users_social_user_id_foreign');
        });
    }
};
