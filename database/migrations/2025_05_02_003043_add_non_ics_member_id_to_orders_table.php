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
            // Add non_ics_member_id column

            // Make user_id nullable since we can have either user_id or non_ics_member_id
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Remove the non_ics_member_id column
            

            // Make user_id required again
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
