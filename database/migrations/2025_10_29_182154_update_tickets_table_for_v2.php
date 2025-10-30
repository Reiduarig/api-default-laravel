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
            
        }
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
        
    }
};
