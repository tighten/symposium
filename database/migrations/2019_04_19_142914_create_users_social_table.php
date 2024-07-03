<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_social', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('users_social_user_id_foreign');
            $table->string('social_id');
            $table->string('service');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('users_social');
    }
};
