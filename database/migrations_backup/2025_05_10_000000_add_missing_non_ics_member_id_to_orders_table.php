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
            // Add non_ics_member_id column if it doesn't exist
            if (!Schema::hasColumn('orders', 'non_ics_member_id')) {
                $table->foreignId('non_ics_member_id')->nullable()->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Remove the non_ics_member_id column if it exists
            if (Schema::hasColumn('orders', 'non_ics_member_id')) {
                $table->dropColumn('non_ics_member_id');
            }
        });
    }
};
