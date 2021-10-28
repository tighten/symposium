<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        if (! app()->environment('testing')) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        $this->call('UsersSeeder');
        $this->call('TalksSeeder');
        $this->call('BiosSeeder');
        $this->call('ConferencesSeeder');
        $this->call('SubmissionsSeeder');
        $this->call('AcceptanceSeeder');
        $this->call('RejectionSeeder');

        if (! app()->environment('testing')) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}
