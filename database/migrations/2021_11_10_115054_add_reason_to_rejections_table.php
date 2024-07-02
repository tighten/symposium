<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rejections', function (Blueprint $table) {
            $table->text('reason')->after('conference_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('rejections', function (Blueprint $table) {
            $table->dropColumn('reason');
        });
    }
};
