<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('masjid_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('serial_number')->unique(); // global serial
            $table->string('building_number');
            $table->unsignedInteger('floors_count');
            $table->unsignedInteger('labs_halls_count'); // combined total
            $table->timestamps();

            $table->unique(['masjid_id', 'building_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
