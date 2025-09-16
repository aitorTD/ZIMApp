<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('candidate_notes');
    }

    /**
     * Reverse the migrations.
     * This is not reversible as we can't reliably recreate the table structure
     */
    public function down(): void
    {
        // This migration is not reversible
    }
};
