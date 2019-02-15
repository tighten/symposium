<?php

use App\Submission;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class AddPrimaryKeyToSubmissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('submissions', function (Blueprint $table) {
            /** Adding to original migration after it runs on prod because SQLite
            $table->uuid('id');
            $table->primary('id');
            **/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('submissions', function (Blueprint $table) {
            /*
            $table->dropPrimary();
            $table->dropColumn('id');
            */
        });
    }
}
