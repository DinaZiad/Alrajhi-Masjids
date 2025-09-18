<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'masjid_id',
        'name',
    ];

    public function masjid()
    {
        return $this->belongsTo(Masjid::class);
    }
}
