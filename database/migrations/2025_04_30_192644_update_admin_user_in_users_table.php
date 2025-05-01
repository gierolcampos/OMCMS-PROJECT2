<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the admin user
        DB::table('users')
            ->where('email', 'admin@gmail.com')
            ->update(['is_admin' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the admin flag
        DB::table('users')
            ->where('email', 'admin@gmail.com')
            ->update(['is_admin' => false]);
    }
};
