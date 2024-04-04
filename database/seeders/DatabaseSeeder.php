<?php

namespace Database\Seeders;

use Database\Seeders\AcceptanceSeeder;
use Database\Seeders\BiosSeeder;
use Database\Seeders\ConferencesSeeder;
use Database\Seeders\RejectionSeeder;
use Database\Seeders\SubmissionsSeeder;
use Database\Seeders\TalksSeeder;
use Database\Seeders\UsersSeeder;
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
