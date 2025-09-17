<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view members',
            'create members',
            'edit members',
            'delete members',
            'view candidates',
            'create candidates',
            'edit candidates',
            'delete candidates',
            'manage roles',
            'access admin panel',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions([
            'view members',
            'create members',
            'edit members',
            'delete members',
            'view candidates',
            'create candidates',
            'edit candidates',
            'delete candidates',
            'manage roles',
            'access admin panel',
        ]);

        // Create sponsor role with permissions
        $sponsorRole = Role::firstOrCreate(['name' => 'sponsor', 'guard_name' => 'web']);
        $sponsorRole->syncPermissions([
            'view members',
            'view candidates',
            'create candidates',
        ]);

        // Create member role with basic permissions
        $memberRole = Role::firstOrCreate(['name' => 'member', 'guard_name' => 'web']);
        $memberRole->syncPermissions([
            'view members',
            'view candidates',
        ]);

        $candidateRole = Role::firstOrCreate(['name' => 'candidate', 'guard_name' => 'web']);
        // Candidates have minimal permissions by default
    }
}
