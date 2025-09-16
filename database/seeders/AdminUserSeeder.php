<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find or create the admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Create or find the admin user
        $user = User::firstOrCreate(
            ['email' => 'aitortrillo93@gmail.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'password' => bcrypt('password'), // You should change this in production
                'email_verified_at' => now(),
            ]
        );
        
        // Assign admin role to the user
        $user->assignRole('admin');
        $this->command->info('Admin user created and role assigned to aitortrillo93@gmail.com');
    }
}
