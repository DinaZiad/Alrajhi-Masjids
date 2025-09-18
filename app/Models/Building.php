<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'masjid_id',
        'serial_number',
        'building_number',
        'direction',
        'floors_count',
        'labs_halls_count',
    ];

    public function masjid()
    {
        return $this->belongsTo(Masjid::class);
    }
}
