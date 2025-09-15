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
        Schema::table('candidates', function (Blueprint $table) {
            // First add the columns as nullable
            $table->string('first_name')->nullable()->after('user_id');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('email')->nullable()->unique()->after('last_name');
            $table->string('phone')->nullable()->after('email');
            $table->foreignId('added_by')->nullable()->constrained('users')->after('user_id');
            
            // Set default status if it doesn't exist
            if (!Schema::hasColumn('candidates', 'status')) {
                $table->string('status')->default('pending');
            } else {
                $table->string('status')->default('pending')->change();
            }
        });

        // Update existing records with default values
        \App\Models\Candidate::whereNull('first_name')->update([
            'first_name' => 'Unknown',
            'last_name' => 'User',
            'email' => 'unknown' . time() . '@example.com', // Temporary email to satisfy unique constraint
            'status' => 'pending'
        ]);

        // Now make the columns required
        Schema::table('candidates', function (Blueprint $table) {
            $table->string('first_name')->nullable(false)->change();
            $table->string('last_name')->nullable(false)->change();
            $table->string('email')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'email', 'phone']);
            $table->dropForeign(['added_by']);
            $table->dropColumn('added_by');
            $table->string('status')->default(null)->change();
        });
    }
};
