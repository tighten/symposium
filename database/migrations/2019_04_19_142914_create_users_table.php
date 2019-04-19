<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->integer('role')->default(0);
            $table->timestamps();
            $table->string('profile_slug')->nullable();
            $table->boolean('enable_profile')->default(0);
            $table->boolean('allow_profile_contact')->default(0);
            $table->text('profile_intro', 65535)->nullable();
            $table->string('name')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('location')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('sublocality')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->boolean('wants_notifications')->default(0);
        });
    }

    public function down()
    {
        Schema::drop('users');
    }
}
