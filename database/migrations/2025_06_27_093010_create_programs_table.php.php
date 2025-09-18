<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();

            // Program Type
            $table->string('program_type'); // e.g. درس علمي, حلقة تحفيظ, إمامة

            // Common Fields
            $table->string('name')->nullable();           // اسم البرنامج
            $table->string('status')->nullable();         // الحالة (بدأت، تأجلت)
            $table->string('level')->nullable();          // المستوى (الأول، الثاني، ...)
            $table->json('location')->nullable();       // الموقع (الدور الأرضي، عمود 55)
            $table->string('attendance_type')->nullable(); // الحضور (عام، طلاب الحلقة)
            $table->time('start_time')->nullable();       // الوقت من
            $table->time('end_time')->nullable();         // الوقت إلى
            $table->text('notes')->nullable();   
            $table->foreignId('masjid_id')->nullable()->constrained('masjids')->onDelete('cascade');
            $table->foreignId('location_id')->nullable()->constrained('locations')->onDelete('set null');
         // ملاحظات

            // For "درس علمي"
            $table->string('field')->nullable();          // المجال (تفسير، توحيد)
            $table->string('specialty')->nullable();      // التخصص
            $table->string('book')->nullable();           // الكتاب المستخدم
            $table->string('teacher')->nullable();        // اسم الشيخ
            $table->string('teacher_link')->nullable();   // رابط البث

            // For "حلقة تحفيظ"
            $table->string('group')->nullable();          // الحلقة (حلقة أبو بكر الصديق)
            $table->string('instructor')->nullable();     // اسم المعلم
            $table->string('instructor_link')->nullable();// رابط البث أو الملف

            // For "إمامة"
            $table->string('imam_name')->nullable();      // اسم الإمام (legacy)
            $table->string('day')->nullable();            // اليوم
            $table->date('date')->nullable();             // التاريخ
            $table->string('imam_fajr')->nullable();      // إمام الفجر
            $table->string('imam_dhuhr')->nullable();     // إمام الظهر
            $table->string('imam_asr')->nullable();       // إمام العصر
            $table->string('imam_maghrib')->nullable();   // إمام المغرب
            $table->string('imam_isha')->nullable();      // إمام العشاء
            $table->time('adhan_fajr')->nullable();       // أذان الفجر
            $table->time('iqama_fajr')->nullable();
            $table->time('adhan_dhuhr')->nullable();
            $table->time('iqama_dhuhr')->nullable();
            $table->time('adhan_asr')->nullable();
            $table->time('iqama_asr')->nullable();
            $table->time('adhan_maghrib')->nullable();
            $table->time('iqama_maghrib')->nullable();
            $table->time('adhan_isha')->nullable();
            $table->time('iqama_isha')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('programs');
    }
}
