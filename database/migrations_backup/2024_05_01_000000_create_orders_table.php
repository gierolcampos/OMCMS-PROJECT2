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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('number')->nullable();
            $table->string('email')->nullable();
            $table->string('method')->default('GCASH');
            $table->string('address')->nullable();
            $table->integer('total_products')->default(0);
            $table->decimal('total_price', 10, 2);
            $table->string('gcash_name')->nullable();
            $table->string('gcash_num')->nullable();
            $table->decimal('gcash_amount', 10, 2)->nullable();
            $table->decimal('change_amount', 10, 2)->nullable();
            $table->string('reference_number')->nullable();
            $table->timestamp('placed_on')->nullable();
            $table->string('payment_status')->default('Pending');
            $table->string('officer_in_charge')->nullable();
            $table->string('receipt_control_number')->nullable();
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
        Schema::dropIfExists('orders');
    }
}; 