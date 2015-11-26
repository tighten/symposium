<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conferences', function (Blueprint $table) {
            $table->string('id', 36)->unique();
            $table->string('title');
            $table->text('description');
            $table->string('url');
            $table->integer('author_id')->unsigned();
            $table->foreign('author_id')
                ->references('id')
                ->on('users');

            $table->dateTime('starts_at')->nullable()->default(null);
            $table->dateTime('ends_at')->nullable()->default(null);
            $table->dateTime('cfp_starts_at')->nullable()->default(null);
            $table->dateTime('cfp_ends_at')->nullable()->default(null);

            $table->integer('joindin_id')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('conferences');
    }
}
