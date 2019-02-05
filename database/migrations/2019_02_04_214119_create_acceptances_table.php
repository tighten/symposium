<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcceptancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acceptances', function (Blueprint $table) {
            $table->string('talk_revision_id', 36);
            $table->foreign('talk_revision_id')
                ->references('id')
                ->on('talk_revisions')
                ->onDelete('cascade');

            $table->string('conference_id', 36);
            $table->foreign('conference_id')
                ->references('id')
                ->on('conferences')
                ->onDelete('cascade');

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
        Schema::dropIfExists('acceptances');
    }
}
