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
        Schema::table('masjids', function (Blueprint $table) {
            $table->text('general_info')->nullable()->comment('معلومات عامة عن المسجد');
            $table->text('available_services')->nullable()->comment('خدمات متاحة في المسجد');
            $table->text('general_statistics')->nullable()->comment('إحصائيات عامة عن المسجد');
            $table->json('programs_count')->nullable()->comment('عدد البرامج والدروس والحلقات');
            $table->timestamp('current_datetime')->nullable()->comment('الوقت والتاريخ الحاليين');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('masjids', function (Blueprint $table) {
            $table->dropColumn([
                'general_info',
                'available_services',
                'general_statistics',
                'programs_count',
                'current_datetime'
            ]);
        });
    }
};
