<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop each column if it exists to be safe on all environments
        if (Schema::hasColumn('teachers', 'phone')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->dropColumn('phone');
            });
        }
        if (Schema::hasColumn('teachers', 'link')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->dropColumn('link');
            });
        }
        if (Schema::hasColumn('teachers', 'notes')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->dropColumn('notes');
            });
        }
    }

    public function down(): void
    {
        // Recreate the columns as nullable to reverse
        if (!Schema::hasColumn('teachers', 'phone')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->string('phone')->nullable()->after('name');
            });
        }
        if (!Schema::hasColumn('teachers', 'link')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->string('link')->nullable()->after('phone');
            });
        }
        if (!Schema::hasColumn('teachers', 'notes')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->text('notes')->nullable()->after('link');
            });
        }
    }
};
