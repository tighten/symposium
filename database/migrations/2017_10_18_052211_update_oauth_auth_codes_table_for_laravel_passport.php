<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOauthAuthCodesTableForLaravelPassport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('oauth_auth_codes');

        Schema::create('oauth_auth_codes', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->integer('user_id');
            $table->integer('client_id');
            $table->text('scopes')->nullable();
            $table->boolean('revoked');
            $table->dateTime('expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('oauth_auth_codes');
        Schema::create('oauth_auth_codes', function (Blueprint $table) {
            $table->string('id', 40)->primary();
            $table->integer('session_id')->unsigned();
            $table->string('redirect_uri');
            $table->integer('expire_time');

            $table->index('session_id');
            
            $table->foreign('session_id')
                ->references('id')->on('oauth_sessions')
                ->onDelete('cascade');
        });
    }
}
