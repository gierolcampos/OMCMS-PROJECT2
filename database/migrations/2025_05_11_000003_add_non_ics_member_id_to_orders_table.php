<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add non_ics_member_id column if it doesn't exist
            if (!Schema::hasColumn('orders', 'non_ics_member_id')) {
                $table->foreignId('non_ics_member_id')->nullable()->after('user_id');
                
                // Add is_non_ics_member column if it doesn't exist
                if (!Schema::hasColumn('orders', 'is_non_ics_member')) {
                    $table->boolean('is_non_ics_member')->default(false)->after('non_ics_member_id');
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the columns if they exist
            if (Schema::hasColumn('orders', 'non_ics_member_id')) {
                $table->dropColumn('non_ics_member_id');
            }
            
            if (Schema::hasColumn('orders', 'is_non_ics_member')) {
                $table->dropColumn('is_non_ics_member');
            }
        });
    }
};
