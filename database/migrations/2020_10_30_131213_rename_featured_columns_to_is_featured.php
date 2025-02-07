<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('featured', 'is_featured');
        });

        Schema::table('conferences', function (Blueprint $table) {
            $table->renameColumn('featured', 'is_featured');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('is_featured', 'featured');
        });

        Schema::table('conferences', function (Blueprint $table) {
            $table->renameColumn('is_featured', 'featured');
        });
    }
};
