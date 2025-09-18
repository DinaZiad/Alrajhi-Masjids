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
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->string('speaker');
            $table->string('required');
            $table->string('location');
            $table->integer('count')->nullable();
            $table->string('topic');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['on_time', 'started', 'postponed', 'cancelled', 'transferred'])->default('on_time');
            $table->text('notes')->nullable();
            $table->string('program_name');
            $table->string('days');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
