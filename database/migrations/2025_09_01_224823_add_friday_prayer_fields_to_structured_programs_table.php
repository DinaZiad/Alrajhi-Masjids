<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('structured_programs', function (Blueprint $table) {
            $table->time('adhan_friday')->nullable()->after('imam_isha');
            $table->time('iqama_friday')->nullable()->after('adhan_friday');
            $table->string('imam_friday')->nullable()->after('iqama_friday');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('structured_programs', function (Blueprint $table) {
            $table->dropColumn(['adhan_friday', 'iqama_friday', 'imam_friday']);
        });
    }
};
