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
            // Remove the specified fields
            $table->dropColumn([
                'name',
                'number',
                'address',
                'total_products',
                'change_amount'
            ]);

            // Make purpose required (can't directly change nullable status in SQLite)
            // For MySQL, we would use:
            // $table->string('purpose')->nullable(false)->change();

            // Instead, we'll handle this in the validation rules
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add back the removed columns
            $table->string('name')->nullable();
            $table->string('number')->nullable();
            $table->text('address')->nullable();
            $table->integer('total_products')->nullable();
            $table->decimal('change_amount', 10, 2)->default(0);
        });
    }
};
