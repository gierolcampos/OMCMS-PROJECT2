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
            // Add cash-related fields
            if (!Schema::hasColumn('non_ics_members', 'receipt_control_number')) {
                $table->string('receipt_control_number')->nullable()->after('payment_status');
            }
            
            if (!Schema::hasColumn('non_ics_members', 'cash_proof_path')) {
                $table->string('cash_proof_path')->nullable()->after('receipt_control_number');
            }
            
            // Add GCash-related fields
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
            
            // Add purpose field
            if (!Schema::hasColumn('non_ics_members', 'purpose')) {
                $table->string('purpose')->nullable()->after('payment_status');
            }
            
            // Add total_price field
            if (!Schema::hasColumn('non_ics_members', 'total_price')) {
                $table->decimal('total_price', 10, 2)->nullable()->after('purpose');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('non_ics_members', function (Blueprint $table) {
            // Remove the added columns
            $table->dropColumn([
                'receipt_control_number',
                'cash_proof_path',
                'gcash_name',
                'gcash_num',
                'reference_number',
                'gcash_proof_path',
                'purpose',
                'total_price'
            ]);
        });
    }
};
