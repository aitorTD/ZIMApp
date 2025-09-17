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
        
        // Create or find the main admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'aitortrillo93@gmail.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'nickname' => 'admin',
                'password' => bcrypt('password'), // You should change this in production
                'email_verified_at' => now(),
            ]
        );
        
        // Create the nitr0 admin user
        $nitr0User = User::firstOrCreate(
            ['email' => 'nitr0@example.com'],
            [
                'first_name' => 'Nitro',
                'last_name' => 'User',
                'nickname' => 'nitr0',
                'password' => bcrypt('password'), // You should change this in production
                'email_verified_at' => now(),
            ]
        );
        
        // Assign admin role to both users
        $adminUser->assignRole('admin');
        $nitr0User->assignRole('admin');
        
        $this->command->info('Admin users created and roles assigned successfully');
        $this->command->info('Email: aitortrillo93@gmail.com, Nickname: admin');
        $this->command->info('Email: nitr0@example.com, Nickname: nitr0');
    }
}
