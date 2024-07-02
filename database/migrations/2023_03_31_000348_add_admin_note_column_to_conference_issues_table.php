<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conference_issues', function (Blueprint $table) {
            $table->text('admin_note')
                ->after('note')
                ->nullable();
            $table->unsignedInteger('closed_by')
                ->constrained()
                ->after('user_id')
                ->nullable();

            $table->foreign('closed_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::table('conference_issues', function (Blueprint $table) {
            $table->dropColumn('admin_note');
            $table->dropForeign('conference_issues_closed_by_foreign');
            $table->dropColumn('closed_by');
        });
    }
};
