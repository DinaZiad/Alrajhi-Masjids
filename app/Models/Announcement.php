<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'content',
        'display_start_at',
        'display_end_at',
        'masjid_id',
        'is_urgent',
    ];

    public function masjid()
    {
        return $this->belongsTo(Masjid::class);
    }
}
