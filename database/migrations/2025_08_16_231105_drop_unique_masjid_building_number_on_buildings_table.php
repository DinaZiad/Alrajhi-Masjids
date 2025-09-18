<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buildings', function (Blueprint $table) {
            // Ensure masjid_id remains indexed for the FK after we drop the composite unique
            $table->index('masjid_id'); // creates `buildings_masjid_id_index` if not exists
        });

        Schema::table('buildings', function (Blueprint $table) {
            // Now drop the composite unique index on (masjid_id, building_number)
            $table->dropUnique('buildings_masjid_id_building_number_unique');

            // Optionally add non-unique indexes for performance (not required, but helpful)
            $table->index(['masjid_id', 'building_number']);
            $table->index('building_number');
        });
    }

    public function down(): void
    {
        Schema::table('buildings', function (Blueprint $table) {
            // Drop the added normal indexes
            $table->dropIndex(['masjid_id', 'building_number']);
            $table->dropIndex(['building_number']);
            // Drop single-column masjid_id index if it exists; unique will cover it again
            $table->dropIndex(['masjid_id']);

            // Restore the composite unique index
            $table->unique(['masjid_id', 'building_number']);
        });
    }
};
