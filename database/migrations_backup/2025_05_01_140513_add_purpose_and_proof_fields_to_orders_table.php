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
            $table->string('purpose')->nullable()->after('total_price');
            $table->string('gcash_proof_path')->nullable()->after('reference_number');
            $table->string('cash_proof_path')->nullable()->after('receipt_control_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('purpose');
            $table->dropColumn('gcash_proof_path');
            $table->dropColumn('cash_proof_path');
        });
    }
};
