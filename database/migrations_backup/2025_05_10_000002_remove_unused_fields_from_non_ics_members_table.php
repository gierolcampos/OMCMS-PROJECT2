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
            // Remove the specified columns if they exist
            if (Schema::hasColumn('non_ics_members', 'membership_type')) {
                $table->dropColumn('membership_type');
            }
            
            if (Schema::hasColumn('non_ics_members', 'membership_expiry')) {
                $table->dropColumn('membership_expiry');
            }
            
            if (Schema::hasColumn('non_ics_members', 'alternative_email')) {
                $table->dropColumn('alternative_email');
            }
            
            if (Schema::hasColumn('non_ics_members', 'department')) {
                $table->dropColumn('department');
            }
            
            if (Schema::hasColumn('non_ics_members', 'address')) {
                $table->dropColumn('address');
            }
            
            if (Schema::hasColumn('non_ics_members', 'notes')) {
                $table->dropColumn('notes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('non_ics_members', function (Blueprint $table) {
            // Add back the removed columns
            $table->string('membership_type')->nullable()->after('payment_status');
            $table->date('membership_expiry')->nullable()->after('membership_type');
            $table->string('alternative_email')->nullable()->after('email');
            $table->string('department')->nullable()->after('course_year_section');
            $table->text('address')->nullable()->after('mobile_no');
            $table->text('notes')->nullable()->after('address');
        });
    }
};
