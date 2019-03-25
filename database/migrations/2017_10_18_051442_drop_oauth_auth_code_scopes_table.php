<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropOauthAuthCodeScopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('oauth_auth_code_scopes');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('oauth_auth_code_scopes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('auth_code_id', 40);
            $table->string('scope_id', 40);

            $table->timestamps();

            $table->index('auth_code_id');
            $table->index('scope_id');

            $table->foreign('auth_code_id')
                ->references('id')->on('oauth_auth_codes')
                ->onDelete('cascade');

            $table->foreign('scope_id')
                ->references('id')->on('oauth_scopes')
                ->onDelete('cascade');
        });
    }
}
