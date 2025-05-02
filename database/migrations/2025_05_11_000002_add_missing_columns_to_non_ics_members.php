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
        Schema::table('non_ics_members', function (Blueprint $table) {
            // Add missing columns
            if (!Schema::hasColumn('non_ics_members', 'purpose')) {
                $table->string('purpose')->nullable()->after('method');
            }
            
            if (!Schema::hasColumn('non_ics_members', 'total_price')) {
                $table->decimal('total_price', 10, 2)->nullable()->after('method');
            }
            
            if (!Schema::hasColumn('non_ics_members', 'description')) {
                $table->text('description')->nullable()->after('method');
            }
            
            if (!Schema::hasColumn('non_ics_members', 'placed_on')) {
                $table->timestamp('placed_on')->nullable()->after('payment_status');
            }
            
            if (!Schema::hasColumn('non_ics_members', 'officer_in_charge')) {
                $table->string('officer_in_charge')->nullable()->after('payment_status');
            }
            
            if (!Schema::hasColumn('non_ics_members', 'receipt_control_number')) {
                $table->string('receipt_control_number')->nullable()->after('officer_in_charge');
            }
            
            if (!Schema::hasColumn('non_ics_members', 'cash_proof_path')) {
                $table->string('cash_proof_path')->nullable()->after('receipt_control_number');
            }
            
            if (!Schema::hasColumn('non_ics_members', 'gcash_name')) {
                $table->string('gcash_name')->nullable()->after('cash_proof_path');
            }
            
            if (!Schema::hasColumn('non_ics_members', 'gcash_num')) {
                $table->string('gcash_num')->nullable()->after('gcash_name');
            }
            
            if (!Schema::hasColumn('non_ics_members', 'reference_number')) {
                $table->string('reference_number')->nullable()->after('gcash_num');
            }
            
            if (!Schema::hasColumn('non_ics_members', 'gcash_proof_path')) {
                $table->string('gcash_proof_path')->nullable()->after('reference_number');
            }
            
            // Drop the payment_status_backup column if it exists
            if (Schema::hasColumn('non_ics_members', 'payment_status_backup')) {
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
            $columns = [
                'purpose',
                'total_price',
                'description',
                'placed_on',
                'officer_in_charge',
                'receipt_control_number',
                'cash_proof_path',
                'gcash_name',
                'gcash_num',
                'reference_number',
                'gcash_proof_path'
            ];
            
            $existingColumns = [];
            foreach ($columns as $column) {
                if (Schema::hasColumn('non_ics_members', $column)) {
                    $existingColumns[] = $column;
                }
            }
            
            if (!empty($existingColumns)) {
                $table->dropColumn($existingColumns);
            }
        });
    }
};
