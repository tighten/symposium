<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->boolean('has_cfp')
                ->default(true)
                ->after('ends_at');
        });
    }

    public function down(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dropColumn('has_cfp');
        });
    }
};
