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
        Schema::table('non_ics_members', function (Blueprint $table) {
            // Add notes column if it doesn't exist
            if (!Schema::hasColumn('non_ics_members', 'notes')) {
                $table->text('notes')->nullable()->after('address');
            }
            
            // Add membership_expiry column if it doesn't exist
            if (!Schema::hasColumn('non_ics_members', 'membership_expiry')) {
                $table->date('membership_expiry')->nullable()->after('membership_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('non_ics_members', function (Blueprint $table) {
            // Remove the columns if they exist
            if (Schema::hasColumn('non_ics_members', 'notes')) {
                $table->dropColumn('notes');
            }
            
            if (Schema::hasColumn('non_ics_members', 'membership_expiry')) {
                $table->dropColumn('membership_expiry');
            }
        });
    }
};
