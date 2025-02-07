<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Eloquent::unguard();

        if (! app()->environment('testing')) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        $this->call([
            UsersSeeder::class,
            TalksSeeder::class,
            BiosSeeder::class,
            ConferencesSeeder::class,
            SubmissionsSeeder::class,
            AcceptanceSeeder::class,
            RejectionSeeder::class,
        ]);

        if (! app()->environment('testing')) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}
