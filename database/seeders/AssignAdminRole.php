<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AssignAdminRole extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'aitortrillo93@gmail.com')->first();
        
        if ($user) {
            $adminRole = Role::where('name', 'admin')->first();
            
            if ($adminRole) {
                // Remove all existing roles and assign admin
                $user->roles()->sync([$adminRole->id]);
                
                $this->command->info('Successfully assigned admin role to: ' . $user->email);
            } else {
                $this->command->error('Admin role not found in the database.');
            }
        } else {
            $this->command->error('User with email aitortrillo93@gmail.com not found.');
        }
    }
}
