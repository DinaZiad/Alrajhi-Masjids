<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'major_id',
        'title',
        'author',
        'description',
    ];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}
