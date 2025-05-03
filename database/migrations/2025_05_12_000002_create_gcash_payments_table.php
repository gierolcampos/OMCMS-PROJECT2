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
        Schema::create('gcash_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('email');
            $table->decimal('total_price', 10, 2);
            $table->string('purpose');
            $table->timestamp('placed_on')->nullable();
            $table->enum('payment_status', ['Paid', 'Pending', 'Rejected', 'Refunded'])->default('Pending');
            $table->string('gcash_name');
            $table->string('gcash_num');
            $table->string('reference_number');
            $table->string('gcash_proof_path')->nullable();
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
        Schema::dropIfExists('gcash_payments');
    }
};
