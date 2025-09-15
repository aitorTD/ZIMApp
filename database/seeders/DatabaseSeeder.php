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
            RoleAndPermissionSeeder::class,
            UserSeeder::class,
            GameSeeder::class,
        ]);
        
        // Ensure admin user exists
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]
        );
        
        // Assign admin role if not already assigned
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
        
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
