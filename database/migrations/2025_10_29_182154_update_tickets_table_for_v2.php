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
        // Check if author_id column exists, if not add it
        if (!Schema::hasColumn('tickets', 'author_id')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->foreignId('author_id')->nullable()->after('user_id')->constrained('users');
            });
            
            // Copy user_id to author_id for existing records
            DB::statement('UPDATE tickets SET author_id = user_id WHERE author_id IS NULL');
            
            // Make author_id not nullable now that we have data
            Schema::table('tickets', function (Blueprint $table) {
                $table->foreignId('author_id')->nullable(false)->change();
            });
        }
        
        // Update existing data to ensure V2 compatibility
        if (Schema::hasColumn('tickets', 'author_id') && Schema::hasColumn('tickets', 'user_id')) {
            DB::statement('UPDATE tickets SET author_id = user_id WHERE author_id IS NULL');
        }
        
        // Update priority enum values for V2 compatibility if needed
        DB::statement("UPDATE tickets SET priority = 'medium' WHERE priority = 'normal'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('tickets', 'author_id')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->dropColumn('author_id');
            });
        }
        
        DB::statement("UPDATE tickets SET priority = 'normal' WHERE priority = 'medium'");
    }
};
