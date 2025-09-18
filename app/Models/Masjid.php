<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Masjid extends Model
{
    protected $fillable = [
        'name',
        'total_area',
        'covered_area_sqm',
        'capacity',
        'gate_count',
        'wing_count',
        'prayer_hall_count',
        'tawaf_per_hour',
        'general_info',
        'available_services',
        'general_statistics',
        'programs_count',
        'current_datetime',
    ];

    protected $casts = [
        'programs_count' => 'array',
        'current_datetime' => 'datetime',
    ];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function structuredPrograms()
    {
        return $this->hasMany(StructuredProgram::class);
    }
}

