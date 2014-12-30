<?php

class TalksSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        DB::table('talk_version_revisions')->truncate();
        DB::table('talk_versions')->truncate();
        DB::table('talks')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $talks = [
            [
                'id' => '03f22222-8888-40da-b571-e982570247f',
                'title' => 'My Great Talk',
                'author_id' => 1,
                'created_at' => '2013-11-27 15:54:41'
            ]
        ];

        foreach ($talks as &$talk) {
            $talk['updated_at'] = new DateTime;
        }

        DB::table('talks')
            ->insert($talks);


        $versions = [
            [
                'id' => '03f22222-6a15-40da-b571-e982570247f',
                'type' => 'seminar',
                'nickname' => 'php conf version',
                'talk_id' => '03f22222-8888-40da-b571-e982570247f',
                'created_at' => '2013-11-27 15:54:41'
            ]
        ];

        foreach ($versions as &$version) {
            $version['updated_at'] = new DateTime;
        }

        DB::table('talk_versions')
            ->insert($versions);


        $revisions = array(
            array(
                'id' => '03f2ae25-6a15-40da-b571-e982570247fd',
                'title' => 'My great talk',
                'description' => 'Description of the talk',
                'level' => 'intermediate',
                'length' => '45',
                'talk_version_id' => '03f22222-6a15-40da-b571-e982570247f',
                'created_at' => '2013-11-27 15:54:41'
            ),
        );

        foreach ($revisions as &$revision) {
            $revision['updated_at'] = new DateTime;
        }

        DB::table('talk_version_revisions')
            ->insert($revisions);
    }
}
