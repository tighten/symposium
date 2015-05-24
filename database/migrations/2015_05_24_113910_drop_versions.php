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
        $this->splitVersionsToTalks();

        Schema::table('talks', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('description');
        });

        Schema::rename('talk_version_revisions', 'talk_revisions');

        Schema::table('talk_revisions', function (Blueprint $table) {
            $table->string('talk_id', 36);
            $table->foreign('talk_id')
                ->references('id')
                ->on('talks')
                ->onDelete('cascade');
        });

        $this->addTalkIdsToTalks();

        // @todo: link to the talk through the version somehow (data migration)

        // @todo: Adjust talk revisions columns

        // Schema::drop('talk_versions'); // later
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No data preservation on the "down" side of this one.
        Schema::table('users', function (Blueprint $table) {
            $table->string('title')->unique();
            $table->text('description');
        });

        Schema::rename('talk_revisions', 'talk_version_revisions');

        // @todo: Delete foreign key and talk_id column on talk_version_revisions
        //
        // @todo: Adjust talk version revisions columns
    }

    /**
     * Since we're dropping versions, we need to split every talk with
     * more than one version to now be multiple talks
     */
    private function splitVersionsToTalks()
    {
        $talks = DB::table('talks')->get();

        foreach ($talks as $talk) {
            $versions = DB::table('talk_versions')
                ->where('talk_id', $talk->id)->get();

            // For each talk version past the first, create a duplicate talk and assign the version to it
            if (count($versions > 1)) {
                foreach ($versions as $i => $version) {
                    if ($i == 0) {
                        continue;
                    }

                    // @todo: This would be the Eloquent syntax, but let's re-write to non-Eloquent so it actually works...
                    $newTalk = new Talk;
                    $newTalk->fill((array) $talk);
                    $newTalk->id = null;
                    $newTalk->save();

                    $version->talk_id = $newTalk->id;
                    $version->save();
                }
            }
        }
    }

    /**
     * Currently revisions are linked to talk_versions, but we need them to
     * link to talks instead.
     */
    private function addTalkIdsToTalks()
    {
        $revisions = DB::table('talk_revisions');

        foreach ($revisions as $revision) {
            $oldVersionId = $revision->version_id;
            $version = DB::table('talk_versions')->where('id', $oldVersionId);
dd($version);
            $revision->talk_id = $version->talk_id;
            $revision->save(); // @todo: How to save in non-Eloquent?
        }
    }
}
