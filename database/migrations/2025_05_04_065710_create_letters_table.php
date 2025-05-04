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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('created_by')->constrained('users');
            $table->string('letter_type')->nullable();
            $table->string('recipient')->nullable();
            $table->string('status')->default('draft'); // draft, finished
            $table->enum('purpose', [
                'Calendar of Activities',
                'Request/Proposal',
                'Financial Statement',
                'Post-Activity Report',
                'Other'
            ])->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
