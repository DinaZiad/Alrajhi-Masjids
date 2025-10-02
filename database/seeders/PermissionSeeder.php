<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing permissions first to ensure correct IDs
        Permission::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $permissions = [
            // ID 1 - Masjid-scoped permissions
            [ 'id' => 1, 'name' => 'manage_masjid', 'description' => 'إدارة المسجد', 'scope' => 'masjid' ],
            
            // ID 7-10 - Admin Management
            [ 'id' => 7, 'name' => 'manage_admins', 'description' => 'إدارة المشرفين', 'scope' => 'general' ],
            [ 'id' => 8, 'name' => 'add_new_admin', 'description' => 'إضافة مشرف جديد', 'scope' => 'general' ],
            [ 'id' => 10, 'name' => 'assign_permissions', 'description' => 'تعيين الصلاحيات', 'scope' => 'general' ],
            
            // ID 11-13 - Announcements
            [ 'id' => 11, 'name' => 'manage_announcements', 'description' => 'إدارة الإعلانات', 'scope' => 'general' ],
            [ 'id' => 12, 'name' => 'add_normal_announcement', 'description' => 'إضافة إعلان عادي', 'scope' => 'general' ],
            [ 'id' => 13, 'name' => 'add_urgent_announcement', 'description' => 'إضافة إعلان عاجل', 'scope' => 'general' ],
            
            // ID 15-16 - Data Management (Program-type-scoped)
            [ 'id' => 15, 'name' => 'manage_data', 'description' => 'إدارة البيانات', 'scope' => 'program' ],
            [ 'id' => 16, 'name' => 'add_new_data', 'description' => 'إضافة بيانات جديدة', 'scope' => 'program' ],
            
            // ID 17-24 - Constants Management
            [ 'id' => 17, 'name' => 'manage_icons', 'description' => 'إدارة الرموز', 'scope' => 'general' ],
            [ 'id' => 18, 'name' => 'manage_hijri_years', 'description' => 'إدارة العام الهجري', 'scope' => 'general' ],
            [ 'id' => 19, 'name' => 'manage_sections', 'description' => 'الأقسام', 'scope' => 'general' ],
            [ 'id' => 20, 'name' => 'manage_levels', 'description' => 'المستويات', 'scope' => 'general' ],
            [ 'id' => 21, 'name' => 'manage_majors', 'description' => 'التخصصات', 'scope' => 'general' ],
            [ 'id' => 22, 'name' => 'manage_books', 'description' => 'الكتب', 'scope' => 'general' ],
            [ 'id' => 23, 'name' => 'manage_program_types', 'description' => 'المجالات', 'scope' => 'general' ],
            [ 'id' => 24, 'name' => 'manage_teachers', 'description' => 'المعلمين', 'scope' => 'general' ],
            
            // ID 28-29 - Additional Management
            [ 'id' => 28, 'name' => 'manage_masjids', 'description' => 'إدارة المساجد', 'scope' => 'general' ],
            [ 'id' => 29, 'name' => 'manage_buildings', 'description' => 'إدارة المباني', 'scope' => 'general' ],
        ];
        
        foreach ($permissions as $perm) {
            Permission::create($perm);
        }
    }
}