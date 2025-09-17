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
            $table->string('nickname')->after('last_name')->nullable();
        });
        
        // Update existing records after the column is added
        if (Schema::hasColumn('candidates', 'last_name') && Schema::hasColumn('candidates', 'nickname')) {
            \DB::table('candidates')->update(['nickname' => \DB::raw('last_name')]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn('nickname');
        });
    }
};
