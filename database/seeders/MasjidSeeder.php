<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Masjid;

class MasjidSeeder extends Seeder
{
    public function run()
    {
        Masjid::create(['name' => 'المسجد الحرام']);
        Masjid::create(['name' => 'المسجد النبوي']);
    }
} 