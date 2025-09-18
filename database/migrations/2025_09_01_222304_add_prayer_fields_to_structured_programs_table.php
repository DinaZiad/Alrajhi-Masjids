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
            // Date field for Imama programs
            $table->date('date')->nullable();
            
            // Fajr Prayer Fields
            $table->time('adhan_fajr')->nullable();
            $table->time('iqama_fajr')->nullable();
            $table->string('imam_fajr')->nullable();
            
            // Dhuhr Prayer Fields
            $table->time('adhan_dhuhr')->nullable();
            $table->time('iqama_dhuhr')->nullable();
            $table->string('imam_dhuhr')->nullable();
            
            // Asr Prayer Fields
            $table->time('adhan_asr')->nullable();
            $table->time('iqama_asr')->nullable();
            $table->string('imam_asr')->nullable();
            
            // Maghrib Prayer Fields
            $table->time('adhan_maghrib')->nullable();
            $table->time('iqama_maghrib')->nullable();
            $table->string('imam_maghrib')->nullable();
            
            // Isha Prayer Fields
            $table->time('adhan_isha')->nullable();
            $table->time('iqama_isha')->nullable();
            $table->string('imam_isha')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('structured_programs', function (Blueprint $table) {
            $table->dropColumn([
                'date',
                'adhan_fajr', 'iqama_fajr', 'imam_fajr',
                'adhan_dhuhr', 'iqama_dhuhr', 'imam_dhuhr',
                'adhan_asr', 'iqama_asr', 'imam_asr',
                'adhan_maghrib', 'iqama_maghrib', 'imam_maghrib',
                'adhan_isha', 'iqama_isha', 'imam_isha'
            ]);
        });
    }
};
