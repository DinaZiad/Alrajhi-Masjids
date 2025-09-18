<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create super admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'phone' => null,
                'note' => 'Default super admin account - please change password after first login',
                'email_verified_at' => now(),
            ]
        );

        // Give super admin all permissions
        $allPermissions = Permission::all();
        
        // Clear existing permissions first
        $admin->permissions()->detach();
        
        // Attach all permissions without specific masjid or program type restrictions
        foreach ($allPermissions as $permission) {
            $admin->permissions()->attach($permission->id, [
                'masjid_id' => null,
                'program_type' => null
            ]);
        }

        $this->command->info('Super admin created successfully:');
        $this->command->info('Email: admin@admin.com');
        $this->command->info('Password: password');
        $this->command->warn('Please change the password after first login!');
    }
}