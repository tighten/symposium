<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropVersions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('talk_versions');
        Schema::table('talks', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('description');
        });
        Schema::rename('talk_version_revisions', 'talk_revisions');
        // @todo: Adjust talk revisions columns
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // @todo: bring back talk_versions table
        // @todo: bring back title and description to talks
        Schema::rename('talk_revisions', 'talk_version_revisions');
        // @todo: Adjust talk version revisions columns
    }
}
