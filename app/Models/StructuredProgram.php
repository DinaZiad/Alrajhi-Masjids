<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StructuredProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'period',
        'weekdays',
        'masjid_id',
        'program_type_id',
        'section_id',
        'major_id',
        'book_id',
        'lesson',
        'level_id',
        'start_time',
        'end_time',
        'language',
        'sign_language_support',
        'teacher_id',
        'location_id',
        'broadcast_link',
        'title',
        'description',
        'status',
        'start_date',
        'end_date',
        'notes',
        // Prayer fields for Imama programs
        'date',
        'adhan_fajr',
        'iqama_fajr',
        'imam_fajr',
        'adhan_dhuhr',
        'iqama_dhuhr',
        'imam_dhuhr',
        'adhan_asr',
        'iqama_asr',
        'imam_asr',
        'adhan_maghrib',
        'iqama_maghrib',
        'imam_maghrib',
        'adhan_isha',
        'iqama_isha',
        'imam_isha',
        'adhan_friday',
        'iqama_friday',
        'imam_friday',
    ];

    protected $casts = [
        'weekdays' => 'array',
        'sign_language_support' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        // Prayer fields casting
        'date' => 'date',
        'adhan_fajr' => 'datetime:H:i',
        'iqama_fajr' => 'datetime:H:i',
        'adhan_dhuhr' => 'datetime:H:i',
        'iqama_dhuhr' => 'datetime:H:i',
        'adhan_asr' => 'datetime:H:i',
        'iqama_asr' => 'datetime:H:i',
        'adhan_maghrib' => 'datetime:H:i',
        'iqama_maghrib' => 'datetime:H:i',
        'adhan_isha' => 'datetime:H:i',
        'iqama_isha' => 'datetime:H:i',
        'adhan_friday' => 'datetime:H:i',
        'iqama_friday' => 'datetime:H:i',
    ];

    /**
     * المسجد (Mosque)
     */
    public function masjid(): BelongsTo
    {
        return $this->belongsTo(Masjid::class);
    }

    /**
     * نوع البرنامج (Program Type)
     */
    public function programType(): BelongsTo
    {
        return $this->belongsTo(ProgramType::class);
    }

    /**
     * القسم (Section)
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * التخصص (Specialization/Major)
     */
    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    /**
     * الكتاب (Book)
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * المستوى (Level)
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * المحاضر (Teacher/Lecturer)
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * المبنى (Building)
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'location_id');
    }

    /**
     * الموقع (Location) - Legacy relationship for backward compatibility
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'location_id');
    }

    /**
     * Get formatted weekdays in Arabic
     */
    public function getFormattedWeekdaysAttribute(): string
    {
        if (!$this->weekdays) {
            return '-';
        }

        $arabicDays = [
            'sunday' => 'الأحد',
            'monday' => 'الإثنين',
            'tuesday' => 'الثلاثاء',
            'wednesday' => 'الأربعاء',
            'thursday' => 'الخميس',
            'friday' => 'الجمعة',
            'saturday' => 'السبت',
        ];

        $translatedDays = array_map(function ($day) use ($arabicDays) {
            return $arabicDays[strtolower($day)] ?? $day;
        }, $this->weekdays);

        return implode('، ', $translatedDays);
    }

    /**
     * Get formatted time range
     */
    public function getFormattedTimeAttribute(): string
    {
        if (!$this->start_time || !$this->end_time) {
            return '-';
        }

        $startTime = \Carbon\Carbon::parse($this->start_time)->format('h:i');
        $endTime = \Carbon\Carbon::parse($this->end_time)->format('h:i');
        $startPeriod = \Carbon\Carbon::parse($this->start_time)->format('A') == 'AM' ? 'ص' : 'م';
        $endPeriod = \Carbon\Carbon::parse($this->end_time)->format('A') == 'AM' ? 'ص' : 'م';

        return "{$startTime} {$startPeriod} - {$endTime} {$endPeriod}";
    }

    /**
     * Get status in Arabic
     */
    public function getStatusInArabicAttribute(): string
    {
        // Since status is now stored directly in Arabic, return as is
        return $this->status;
    }

    /**
     * Scope for active programs (started programs)
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'بدأت');
    }

    /**
     * Scope for programs by masjid
     */
    public function scopeByMasjid($query, $masjidId)
    {
        return $query->where('masjid_id', $masjidId);
    }

    /**
     * Scope for programs by section
     */
    public function scopeBySection($query, $sectionId)
    {
        return $query->where('section_id', $sectionId);
    }
}