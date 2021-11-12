<?php

namespace Database\Seeders;

use App\Models\Submission;
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

        $this->call(UsersSeeder::class);
        $this->call(TalksSeeder::class);
        $this->call(BiosSeeder::class);
        $this->call(ConferencesSeeder::class);
        $this->call(SubmissionsSeeder::class);
        $this->call(AcceptanceSeeder::class);
        $this->call(RejectionSeeder::class);

        if (! app()->environment('testing')) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}
