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
        Schema::create('cash_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('email');
            $table->decimal('total_price', 10, 2);
            $table->string('purpose');
            $table->timestamp('placed_on')->nullable();
            $table->enum('payment_status', ['Paid', 'Pending', 'Rejected', 'Refunded'])->default('Pending');
            $table->string('officer_in_charge')->nullable();
            $table->string('receipt_control_number')->nullable();
            $table->string('cash_proof_path')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_payments');
    }
};
