<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

        \App\Submission::all()->map(function($submission){
            $submission->id = \Ramsey\Uuid\Uuid::uuid4();
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
