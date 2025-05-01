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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('event_type')->nullable(); // Club ceremony, Technical workshop, Club meeting, etc.
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
            $table->string('location');
            $table->string('location_details')->nullable(); // Building, room, etc.
            $table->enum('status', ['upcoming', 'completed', 'cancelled'])->default('upcoming');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
