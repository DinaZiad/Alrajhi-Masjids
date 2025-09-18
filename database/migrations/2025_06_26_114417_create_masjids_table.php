<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateMasjidsTable extends Migration
{
    public function up()
    {
        Schema::create('masjids', function (Blueprint $table) {
            $table->id();

            $table->string('name');                 // اسم المسجد (مثل: المسجد الحرام)
            $table->string('total_area')->nullable();      // المساحة الإجمالية
            $table->integer('capacity')->nullable();       // الطاقة الاستيعابية
            $table->integer('gate_count')->nullable();     // عدد الأبواب
            $table->integer('wing_count')->nullable();     // عدد الأروقة
            $table->integer('prayer_hall_count')->nullable(); // عدد المصليات
            $table->integer('tawaf_per_hour')->nullable(); // عدد الطائفين كل ساعة

            $table->timestamps();
        });
    }



    public function down()
    {
        Schema::dropIfExists('masjids');
    }
}
