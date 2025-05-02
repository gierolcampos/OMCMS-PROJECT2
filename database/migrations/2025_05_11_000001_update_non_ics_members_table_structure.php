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
            // Check and add missing columns
            if (!Schema::hasColumn('non_ics_members', 'method')) {
                $table->string('method')->nullable()->after('mobile_no');
            }
            
            if (!Schema::hasColumn('non_ics_members', 'description')) {
                $table->text('description')->nullable()->after('purpose');
            }
            
            if (!Schema::hasColumn('non_ics_members', 'placed_on')) {
                $table->timestamp('placed_on')->nullable()->after('payment_status');
            }
            
            if (!Schema::hasColumn('non_ics_members', 'officer_in_charge')) {
                $table->string('officer_in_charge')->nullable()->after('placed_on');
            }
            
            // Convert payment_status to enum if it's not already
            if (Schema::hasColumn('non_ics_members', 'payment_status')) {
                // First, create a backup of the current payment_status values
                DB::statement('ALTER TABLE non_ics_members ADD COLUMN payment_status_backup VARCHAR(255)');
                DB::statement('UPDATE non_ics_members SET payment_status_backup = payment_status');
                
                // Drop the existing column
                $table->dropColumn('payment_status');
                
                // Add the new enum column
                $table->enum('payment_status', ['Paid', 'Pending', 'Failed', 'Refunded', 'None'])->default('None')->after('purpose');
                
                // Restore values with mapping
                DB::statement("UPDATE non_ics_members SET payment_status = 
                    CASE 
                        WHEN payment_status_backup = 'Paid' THEN 'Paid'
                        WHEN payment_status_backup = 'Pending' THEN 'Pending'
                        WHEN payment_status_backup = 'Failed' THEN 'Failed'
                        WHEN payment_status_backup = 'Refunded' THEN 'Refunded'
                        ELSE 'None'
                    END");
                
                // Drop the backup column
                $table->dropColumn('payment_status_backup');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('non_ics_members', function (Blueprint $table) {
            // Drop the added columns
            $table->dropColumn([
                'method',
                'description',
                'placed_on',
                'officer_in_charge'
            ]);
            
            // Convert payment_status back to string
            if (Schema::hasColumn('non_ics_members', 'payment_status')) {
                // First, create a backup of the current payment_status values
                DB::statement('ALTER TABLE non_ics_members ADD COLUMN payment_status_backup VARCHAR(255)');
                DB::statement('UPDATE non_ics_members SET payment_status_backup = payment_status');
                
                // Drop the existing column
                $table->dropColumn('payment_status');
                
                // Add back as a string column
                $table->string('payment_status')->default('None')->after('purpose');
                
                // Restore values
                DB::statement('UPDATE non_ics_members SET payment_status = payment_status_backup');
                
                // Drop the backup column
                $table->dropColumn('payment_status_backup');
            }
        });
    }
};
