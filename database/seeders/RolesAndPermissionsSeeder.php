<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
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
            'view candidates',
            'create candidates',
            'edit candidates',
            'delete candidates',
            'view notes',
            'create notes',
            'edit notes',
            'delete notes',
            'manage users',
            'manage roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign created permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        $memberRole = Role::firstOrCreate(['name' => 'member']);
        $memberRole->syncPermissions([
            'view candidates',
            'create candidates',
            'edit candidates',
            'view notes',
            'create notes',
            'edit notes',
            'delete notes',
        ]);

        $sponsorRole = Role::firstOrCreate(['name' => 'sponsor']);
        $sponsorRole->syncPermissions([
            'view candidates',
            'view notes',
            'create notes',
        ]);

        $candidateRole = Role::firstOrCreate(['name' => 'candidate']);
        $candidateRole->syncPermissions([
            'view candidates',
        ]);
    }
}
