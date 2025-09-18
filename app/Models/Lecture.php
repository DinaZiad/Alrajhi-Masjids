<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = [
        'speaker',
        'required',
        'location',
        'count',
        'topic',
        'start_time',
        'end_time',
        'status',
        'notes',
        'program_name',
        'days',
        'start_date',
        'end_date',
        'category',
    ];
}
