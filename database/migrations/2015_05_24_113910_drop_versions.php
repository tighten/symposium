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
            $table->dropForeign('talk_version_revisions_talk_version_id_foreign');
        });

        $this->addTalkIdsToTalks();

        Schema::table('talk_revisions', function (Blueprint $table) {
            $table->foreign('talk_id')
                ->references('id')
                ->on('talks')
                ->onDelete('cascade');
        });


        Schema::table('submissions', function($table) {
            // @todo: Drop foreign that references this or that this is a part of
            $table->dropForeign('submissions_talk_version_revision_id_foreign');

            $table->renameColumn('talk_version_revision_id', 'talk_revision_id');

            $table->foreign('talk_revision_id')
                ->references('id')
                ->on('talk_revisions')
                ->onDelete('cascade');
        });

        // Schema::drop('talk_versions'); // later?
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // @todo: Flesh this whole thing out
        // No data preservation on the "down" side of this one.
        Schema::table('users', function (Blueprint $table) {
            $table->string('title')->unique();
            $table->text('description');
        });

        Schema::rename('talk_revisions', 'talk_version_revisions');

        // @todo: Delete foreign key and talk_id column on talk_version_revisions
        // @todo: bring back dropped index aboe
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

                    // Duplicate the talk
                    $newTalkId = (string)\Rhumsaa\Uuid\Uuid::uuid4();
                    DB::table('talks')->insert([
                        'id' => $newTalkId,
                        'title' => $talk->title,
                        'author_id' => $talk->author_id,
                        'created_at' => $talk->created_at,
                        'updated_at' => $talk->updated_at,
                    ]);

                    // Assign the version to the new talk
                    DB::table('talk_versions')
                        ->where('id', $version->id)
                        ->update([
                            'talk_id' => $newTalkId
                        ]);
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
        $revisions = DB::table('talk_revisions')->get();

        foreach ($revisions as $revision) {
            $oldVersionId = $revision->talk_version_id;
            $version = DB::table('talk_versions')->where('id', $oldVersionId)->first();

            DB::table('talk_revisions')
                ->where('id', $revision->id)
                ->update([
                    'talk_id' => $version->talk_id
                ]);
        }
    }
}
