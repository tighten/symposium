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
            $table->uuid('id');
            $table->primary('id');
        });

        Submission::all()->map(function ($submission){
            $submission->id = Uuid::uuid4();
            $submission->save();
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
            $table->dropPrimary();
            $table->dropColumn('id');
        });
    }
}
