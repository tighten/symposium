<?php

class TalkTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('talks')->truncate();

        $talks = array(
            array(
                'title' => 'My great talk',
                'description' => 'Description of the talk',
                'Body' => 'Actual body of the talk',
                'author_id' => 1,
                'created_at' => '2013-11-27 15:54:41'
            ),
        );

        foreach ($talks as &$talk) {
            $talk['updated_at'] = new DateTime;
        }

        DB::table('talks')
            ->insert($talks);
    }
}
