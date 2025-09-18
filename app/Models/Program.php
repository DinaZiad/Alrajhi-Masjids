<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'masjid_id',
        'location_id',
        'program_type',
        'name',
        'status',
        'level',
        'location',
        'attendance_type',
        'start_time',
        'end_time',
        'notes',
        'field',
        'specialty',
        'book',
        'teacher',
        'teacher_link',
        'group',
        'instructor',
        'instructor_link',
        'imam_name',
        'day',
        'date',
        'imam_fajr',
        'imam_dhuhr',
        'imam_asr',
        'imam_maghrib',
        'imam_isha',
        'adhan_fajr',
        'iqama_fajr',
        'adhan_dhuhr',
        'iqama_dhuhr',
        'adhan_asr',
        'iqama_asr',
        'adhan_maghrib',
        'iqama_maghrib',
        'adhan_isha',
        'iqama_isha',
    ];

    protected $casts = [
        'location' => 'array',
    ];

    public function masjid()
    {
        return $this->belongsTo(Masjid::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function locationRelation()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
