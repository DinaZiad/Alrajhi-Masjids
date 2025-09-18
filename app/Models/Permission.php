<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function admins()
    {
        return $this->belongsToMany(User::class, 'admin_permissions', 'permission_id', 'admin_id')
            ->withPivot(['masjid_id', 'program_type'])
            ->withTimestamps();
    }
}
