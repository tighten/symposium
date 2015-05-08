<?php

use Illuminate\Database\Seeder;

class TalksSeeder extends Seeder
{
    public function run()
    {
        TalkVersionRevision::truncate();
        TalkVersion::truncate();
        Talk::truncate();

        $talks = [
            [
                'id' => '03f22222-8888-40da-b571-e982570247f',
                'title' => 'My Great Talk',
                'author_id' => 1,
                'created_at' => '2013-11-27 15:54:41'
            ],
            [
                'id' => '03f22222-8888-40da-b571-e982570247d',
                'title' => 'My Terrible Talk',
                'author_id' => 1,
                'created_at' => '2013-10-27 15:54:41'
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
                'nickname' => 'php conf version',
                'talk_id' => '03f22222-8888-40da-b571-e982570247f',
                'created_at' => '2013-11-27 15:54:41'
            ],
            [
                'id' => '03f22222-6a15-40da-b571-e9825702471',
                'nickname' => 'frontend conf version',
                'talk_id' => '03f22222-8888-40da-b571-e982570247f',
                'created_at' => '2013-11-28 15:54:41'
            ]
        ];

        foreach ($versions as &$version) {
            $version['updated_at'] = new DateTime;
        }

        DB::table('talk_versions')
            ->insert($versions);


        $revisions = [
            [
                'id' => '03f2ae25-6a15-40da-b571-e982570247fa',
                'title' => 'My great talk',
                'description' => 'Description of the talk',
                'type' => 'seminar',
                'level' => 'intermediate',
                'length' => '45',
                'talk_version_id' => '03f22222-6a15-40da-b571-e982570247f',
                'created_at' => '2013-11-29 15:54:41'
            ],
            [
                'id' => '03f2ae25-6a15-40da-b571-e982570247fd',
                'title' => 'My awesome talk',
                'description' => 'Description of the talk',
                'type' => 'seminar',
                'level' => 'intermediate',
                'length' => '45',
                'talk_version_id' => '03f22222-6a15-40da-b571-e982570247f',
                'created_at' => '2013-11-27 15:54:41'
            ],
            [
                'id' => '03f2ae25-6a15-40da-b571-e982570247f5',
                'title' => 'My awesome talk',
                'description' => 'Description of the talk',
                'type' => 'seminar',
                'level' => 'intermediate',
                'length' => '45',
                'talk_version_id' => '03f22222-6a15-40da-b571-e9825702471',
                'created_at' => '2013-11-28 15:54:41'
            ],
        ];

        foreach ($revisions as &$revision) {
            $revision['updated_at'] = new DateTime;
        }

        DB::table('talk_version_revisions')
            ->insert($revisions);
    }
}
