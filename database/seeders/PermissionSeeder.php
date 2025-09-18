<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Masjid-scoped permissions
            [ 'name' => 'manage_masjid', 'description' => 'إدارة المسجد', 'scope' => 'masjid' ],
            // Program-type-scoped permissions
            [ 'name' => 'manage_data', 'description' => 'إدارة البيانات', 'scope' => 'program' ],
            [ 'name' => 'add_new_data', 'description' => 'إضافة بيانات جديدة', 'scope' => 'program' ],
            // General permissions
            [ 'name' => 'manage_admins', 'description' => 'إدارة المشرفين', 'scope' => 'general' ],
            [ 'name' => 'add_new_admin', 'description' => 'إضافة مشرف جديد', 'scope' => 'general' ],
          
            [ 'name' => 'assign_permissions', 'description' => 'تعيين الصلاحيات', 'scope' => 'general' ],
            [ 'name' => 'manage_announcements', 'description' => 'إدارة الإعلانات', 'scope' => 'general' ],
            [ 'name' => 'add_normal_announcement', 'description' => 'إضافة إعلان عادي', 'scope' => 'general' ],
            [ 'name' => 'add_urgent_announcement', 'description' => 'إضافة إعلان عاجل', 'scope' => 'general' ],
            [ 'name' => 'manage_constants', 'description' => 'إدارة الثوابت', 'scope' => 'general' ],
            [ 'name' => 'manage_icons', 'description' => 'إدارة الرموز', 'scope' => 'general' ],
            [ 'name' => 'manage_hijri_years', 'description' => 'إدارة العام الهجري', 'scope' => 'general' ],
            [ 'name' => 'manage_sections', 'description' => 'الأقسام', 'scope' => 'general' ],
            [ 'name' => 'manage_levels', 'description' => 'المستويات', 'scope' => 'general' ],
            [ 'name' => 'manage_majors', 'description' => 'التخصصات', 'scope' => 'general' ],
            [ 'name' => 'manage_books', 'description' => 'الكتب', 'scope' => 'general' ],
            [ 'name' => 'manage_program_types', 'description' => 'المجالات', 'scope' => 'general' ],
            [ 'name' => 'manage_teachers', 'description' => 'المعلمين', 'scope' => 'general' ],
            [ 'name' => 'manage_masjids', 'description' => 'إدارة المساجد', 'scope' => 'general' ],
            [ 'name' => 'manage_buildings', 'description' => 'إدارة المباني', 'scope' => 'general' ],

        ];
        foreach ($permissions as $perm) {
            Permission::updateOrCreate(['name' => $perm['name']], $perm);
        }
    }
}