<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid constraint issues
        if (config('database.default') !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        // Clear existing data
        $this->truncateTables([
            'evaluations',
            'sponsor_candidate',
            'role_user',
            'candidates',
            'sponsors',
            'games',
            'users',
            'roles',
        ]);

        // Enable foreign key checks
        if (config('database.default') !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        // Run seeders in the correct order
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            GameSeeder::class,
        ]);
        
        $this->command->info('Database seeded successfully!');
    }

    /**
     * Truncate the given tables.
     */
    protected function truncateTables(array $tables): void
    {
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
            }
        }
    }
}
