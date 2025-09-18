<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, check if the foreign key exists and drop it
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Get the constraint name
        $constraints = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'structured_programs' 
            AND COLUMN_NAME = 'location_id' 
            AND REFERENCED_TABLE_NAME = 'locations'
        ");
        
        // Drop the constraint if it exists
        foreach ($constraints as $constraint) {
            DB::statement("ALTER TABLE structured_programs DROP FOREIGN KEY {$constraint->CONSTRAINT_NAME}");
        }
        
        // Add the new foreign key constraint pointing to buildings table
        DB::statement('ALTER TABLE structured_programs ADD CONSTRAINT structured_programs_location_id_foreign FOREIGN KEY (location_id) REFERENCES buildings(id) ON DELETE SET NULL');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('structured_programs', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['location_id']);
            
            // Restore the old foreign key constraint pointing to locations table
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
        });
    }
};
