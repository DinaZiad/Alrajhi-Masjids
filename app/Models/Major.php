<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'name',
        'description',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
