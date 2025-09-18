<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'details',
    ];

    protected $casts = [
        'details' => 'array',
    ];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
} 