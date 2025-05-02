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
        Schema::create('non_ics_members', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('fullname')->nullable();
            $table->string('student_id')->nullable();
            $table->string('course_year_section');
            $table->string('mobile_no')->nullable();
            
            // Payment details
            $table->string('method')->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->string('purpose')->nullable();
            $table->text('description')->nullable();
            $table->enum('payment_status', ['Paid', 'Pending', 'Failed', 'Refunded', 'None'])->default('None');
            $table->timestamp('placed_on')->nullable();
            
            // Cash payment fields
            $table->string('officer_in_charge')->nullable();
            $table->string('receipt_control_number')->nullable();
            $table->string('cash_proof_path')->nullable();
            
            // GCash payment fields
            $table->string('gcash_name')->nullable();
            $table->string('gcash_num')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('gcash_proof_path')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('non_ics_members');
    }
};
