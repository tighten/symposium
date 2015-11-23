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
        // @todo: Would be nice to merge all these changes back into original creates like I did with the other migrations for simplicity and SQLite-happiness
        // $this->splitVersionsToTalks();

        // title & description removal Separate because https://github.com/laravel/framework/issues/2979
        Schema::table('talks', function (Blueprint $table) {
            $table->dropColumn('title');
        });

        Schema::table('talks', function (Blueprint $table) {
            $table->dropColumn('description');
        });

        Schema::rename('talk_version_revisions', 'talk_revisions');

        Schema::table('talk_revisions', function (Blueprint $table) {
            $table->string('talk_id', 36)->default('');
            $table->dropForeign('talk_version_revisions_talk_version_id_foreign');
        });

        // $this->addTalkIdsToTalks();

        Schema::table('talk_revisions', function (Blueprint $table) {
            $table->foreign('talk_id')
                ->references('id')
                ->on('talks')
                ->onDelete('cascade');

            $table->dropColumn('talk_version_id');
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeign('submissions_talk_version_revision_id_foreign');

            $table->renameColumn('talk_version_revision_id', 'talk_revision_id');

            $table->foreign('talk_revision_id')
                ->references('id')
                ->on('talk_revisions')
                ->onDelete('cascade');
        });

        Schema::drop('talk_versions');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No data preservation on the "down" side of this one.
        if (! App::environment('testing')) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }
        foreach (['favorites', 'conferences', 'submissions', 'talk_revisions', 'talks'] as $table) {
            DB::table($table)->truncate();
        }
        if (! App::environment('testing')) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }

        Schema::table('talks', function (Blueprint $table) {
            $table->string('title')->nullable()->unique();
            $table->text('description')->nullable();
        });

        Schema::create('talk_versions', function(Blueprint $table)
        {
            $table->string('id', 36)->unique();
            $table->string('nickname', 150);

            $table->timestamps();

            $table->string('talk_id', 36);
            $table->foreign('talk_id')
                ->references('id')
                ->on('talks')
                ->onDelete('cascade');
        });

        Schema::rename('talk_revisions', 'talk_version_revisions');

        Schema::table('talk_version_revisions', function (Blueprint $table) {
            $table->dropForeign('talk_revisions_talk_id_foreign');
            $table->dropColumn('talk_id');

            $table->string('talk_version_id', 36)->nullable();
            $table->foreign('talk_version_id')
                ->references('id')
                ->on('talk_versions')
                ->onDelete('cascade');
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeign('submissions_talk_revision_id_foreign');
            $table->renameColumn('talk_revision_id', 'talk_version_revision_id');
            $table->foreign('talk_version_revision_id')
                ->references('id')
                ->on('talk_version_revisions')
                ->onDelete('cascade');
        });
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

        // Add a talk_id foreign key to each revision (since we're dropping version_id)
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
