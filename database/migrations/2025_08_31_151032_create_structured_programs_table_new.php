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
        if (!Schema::hasTable('structured_programs')) {
            Schema::create('structured_programs', function (Blueprint $table) {
                $table->id();
                $table->string('title'); // عنوان البرنامج
                $table->string('period')->nullable(); // الفترة
                $table->json('weekdays')->nullable(); // أيام الأسبوع
                $table->unsignedBigInteger('masjid_id'); // المسجد
                $table->unsignedBigInteger('section_id')->nullable(); // القسم
                $table->unsignedBigInteger('major_id')->nullable(); // التخصص
                $table->unsignedBigInteger('book_id')->nullable(); // الكتاب
                $table->string('lesson')->nullable(); // الدرس
                $table->unsignedBigInteger('level_id')->nullable(); // المستوى
                $table->time('start_time')->nullable(); // وقت البداية
                $table->time('end_time')->nullable(); // وقت النهاية
                $table->string('language')->default('العربية'); // اللغة
                $table->boolean('sign_language_support')->default(false); // دعم لغة الإشارة
                $table->unsignedBigInteger('teacher_id')->nullable(); // المحاضر
                $table->unsignedBigInteger('location_id')->nullable(); // الموقع
                $table->string('broadcast_link')->nullable(); // رابط البث
                $table->text('description')->nullable(); // الوصف
                $table->text('notes')->nullable(); // الملاحظات
                $table->enum('status', ['active', 'inactive', 'suspended'])->default('active'); // الحالة
                $table->date('start_date')->nullable(); // تاريخ البداية
                $table->date('end_date')->nullable(); // تاريخ النهاية
                $table->timestamps();

                // Foreign key constraints
                $table->foreign('masjid_id')->references('id')->on('masjids')->onDelete('cascade');
                $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
                $table->foreign('major_id')->references('id')->on('majors')->onDelete('set null');
                $table->foreign('book_id')->references('id')->on('books')->onDelete('set null');
                $table->foreign('level_id')->references('id')->on('levels')->onDelete('set null');
                $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
                $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');

                // Indexes for performance
                $table->index(['masjid_id', 'status']);
                $table->index(['section_id', 'major_id']);
                $table->index(['start_date', 'end_date']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('structured_programs');
    }
};
