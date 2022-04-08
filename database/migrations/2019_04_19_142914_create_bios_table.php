<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up()
    {
        Schema::create('bios', function (Blueprint $table) {
            $table->string('id', 36)->unique();
            $table->string('nickname');
            $table->text('body', 65535);
            $table->integer('user_id')->unsigned()->index('bios_user_id_foreign');
            $table->timestamps();
            $table->boolean('public')->default(0);
        });
    }

    public function down()
    {
        Schema::drop('bios');
    }
};
