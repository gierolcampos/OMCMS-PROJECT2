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
            // Remove unused columns
            $columns = [
                'alternative_email',
                'department',
                'address',
                'membership_type'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('non_ics_members', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('non_ics_members', function (Blueprint $table) {
            // Add back the removed columns
            if (!Schema::hasColumn('non_ics_members', 'alternative_email')) {
                $table->string('alternative_email')->nullable();
            }
            
            if (!Schema::hasColumn('non_ics_members', 'department')) {
                $table->string('department')->nullable();
            }
            
            if (!Schema::hasColumn('non_ics_members', 'address')) {
                $table->text('address')->nullable();
            }
            
            if (!Schema::hasColumn('non_ics_members', 'membership_type')) {
                $table->string('membership_type')->nullable();
            }
        });
    }
};
