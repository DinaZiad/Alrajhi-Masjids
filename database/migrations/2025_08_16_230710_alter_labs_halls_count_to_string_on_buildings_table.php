<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Assumes MySQL/MariaDB
        DB::statement('ALTER TABLE buildings MODIFY labs_halls_count VARCHAR(255) NULL');
    }

    public function down(): void
    {
        // Revert back to integer if needed
        DB::statement('ALTER TABLE buildings MODIFY labs_halls_count INT NULL');
    }
};
