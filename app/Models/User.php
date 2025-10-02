<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'note',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'admin_permissions', 'admin_id', 'permission_id')
            ->withPivot(['masjid_id', 'program_type'])
            ->withTimestamps();
    }

    /**
     * Check if the admin has a permission, optionally scoped to masjid or program type.
     */
    public function hasPermission($permission, $masjidId = null, $programType = null)
    {
        // Super admin has all permissions
        if ($this->role === 'super_admin') {
            return true;
        }

        return $this->permissions()
            ->where('name', $permission)
            ->when($masjidId, function ($query) use ($masjidId) {
                $query->wherePivot('masjid_id', $masjidId);
            })
            ->when($programType, function ($query) use ($programType) {
                $query->wherePivot('program_type', $programType);
            })
            ->exists();
    }

    /**
     * Check if the admin has any constants permissions.
     */
    public function hasAnyConstantsPermission()
    {
        // Super admin has all permissions
        if ($this->role === 'super_admin') {
            return true;
        }

        $constantsPermissions = [
            'manage_constants',
            'manage_icons',
            'manage_hijri_years',
            'manage_sections',
            'manage_levels',
            'manage_majors',
            'manage_books',
            'manage_teachers',
            'manage_buildings',
            'manage_masjids'
        ];

        return $this->permissions()
            ->whereIn('name', $constantsPermissions)
            ->exists();
    }

    /**
     * Check if the admin has general program types management permission (not scoped).
     */
    public function hasGeneralProgramTypesPermission()
    {
        // Super admin has all permissions
        if ($this->role === 'super_admin') {
            return true;
        }

        return $this->permissions()
            ->where('name', 'manage_program_types')
            ->whereNull('admin_permissions.masjid_id')
            ->whereNull('admin_permissions.program_type')
            ->exists();
    }
}
