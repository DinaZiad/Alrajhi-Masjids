<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('program_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Seed initial types from existing programs and known defaults
        $existing = DB::table('programs')->select('program_type')->whereNotNull('program_type')->distinct()->pluck('program_type')->toArray();
        $defaults = ['درس علمي', 'حلقة تحفيظ', 'إمامة'];
        $all = collect(array_unique(array_filter(array_merge($defaults, $existing))))
            ->map(fn($name) => ['name' => $name, 'created_at' => now(), 'updated_at' => now()])
            ->values()
            ->all();

        if (!empty($all)) {
            DB::table('program_types')->insert($all);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('program_types');
    }
};
