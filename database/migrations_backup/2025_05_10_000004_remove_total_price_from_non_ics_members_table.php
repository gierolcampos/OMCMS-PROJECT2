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
            // Remove the total_price column if it exists
            if (Schema::hasColumn('non_ics_members', 'total_price')) {
                $table->dropColumn('total_price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('non_ics_members', function (Blueprint $table) {
            // Add back the total_price column
            if (!Schema::hasColumn('non_ics_members', 'total_price')) {
                $table->decimal('total_price', 10, 2)->nullable()->after('purpose');
            }
        });
    }
};
