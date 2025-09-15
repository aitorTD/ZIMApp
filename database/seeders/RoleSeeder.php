<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator with full access to all features',
            ],
            [
                'name' => 'member',
                'description' => 'Regular club member with standard access',
            ],
            [
                'name' => 'sponsor',
                'description' => 'Member who can sponsor and evaluate candidates',
            ],
            [
                'name' => 'candidate',
                'description' => 'New applicant going through the evaluation process',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
}
