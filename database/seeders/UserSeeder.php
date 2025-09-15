<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Role;
use App\Models\Sponsor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@zima.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'membership_status' => 'active',
            'phone' => '+34600123456',
            'date_of_birth' => '1980-01-01',
            'address' => '123 Admin Street',
            'city' => 'Madrid',
            'country' => 'Spain',
            'postal_code' => '28001',
        ]);
        $admin->roles()->attach(Role::where('name', 'admin')->first());

        // Create sponsor users
        $sponsors = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'sponsor1@zima.test',
                'max_candidates' => 3,
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'sponsor2@zima.test',
                'max_candidates' => 2,
            ],
        ];

        foreach ($sponsors as $sponsorData) {
            $user = User::create([
                'first_name' => $sponsorData['first_name'],
                'last_name' => $sponsorData['last_name'],
                'email' => $sponsorData['email'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'membership_status' => 'active',
                'phone' => '+34600' . rand(100000, 999999),
                'date_of_birth' => now()->subYears(rand(25, 50))->format('Y-m-d'),
                'address' => rand(1, 200) . ' ' . collect(['Main St', 'Oak Ave', 'Pine Rd', 'Maple Dr'])->random(),
                'city' => 'Madrid',
                'country' => 'Spain',
                'postal_code' => '280' . str_pad(rand(1, 50), 2, '0', STR_PAD_LEFT),
            ]);
            
            $user->roles()->attach(Role::where('name', 'sponsor')->first());
            $user->roles()->attach(Role::where('name', 'member')->first());
            
            // Create sponsor profile
            $user->sponsor()->create([
                'max_candidates' => $sponsorData['max_candidates'],
                'current_candidates_count' => 0,
                'is_active' => true,
            ]);
        }

        // Create regular member users
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'first_name' => 'Member' . $i,
                'last_name' => 'User',
                'email' => 'member' . $i . '@zima.test',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'membership_status' => 'active',
                'phone' => '+34600' . rand(100000, 999999),
                'date_of_birth' => now()->subYears(rand(18, 60))->format('Y-m-d'),
                'address' => rand(1, 200) . ' ' . collect(['Elm St', 'Cedar Ln', 'Birch Blvd', 'Willow Way'])->random(),
                'city' => 'Madrid',
                'country' => 'Spain',
                'postal_code' => '280' . str_pad(rand(1, 50), 2, '0', STR_PAD_LEFT),
            ]);
            $user->roles()->attach(Role::where('name', 'member')->first());
        }

        // Create candidate users
        $sponsorUsers = User::whereHas('roles', function($q) {
            $q->where('name', 'sponsor');
        })->get();
        
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'first_name' => 'Candidate' . $i,
                'last_name' => 'Applicant',
                'email' => 'candidate' . $i . '@zima.test',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'membership_status' => 'pending',
                'phone' => '+34600' . rand(100000, 999999),
                'date_of_birth' => now()->subYears(rand(18, 40))->format('Y-m-d'),
                'address' => rand(1, 200) . ' ' . collect(['Aspen Dr', 'Redwood Rd', 'Spruce St', 'Sycamore Ave'])->random(),
                'city' => 'Madrid',
                'country' => 'Spain',
                'postal_code' => '280' . str_pad(rand(1, 50), 2, '0', STR_PAD_LEFT),
            ]);
            
            $user->roles()->attach(Role::where('name', 'candidate')->first());
            
            // Create candidate profile
            $candidate = $user->candidate()->create([
                'application_date' => now()->subDays(rand(1, 30)),
                'status' => collect(['pending', 'under_review', 'accepted', 'rejected'])->random(),
                'rejection_reason' => null,
                'status_updated_at' => now(),
                'total_score' => 0,
                'evaluations_count' => 0,
            ]);
            
            // Assign random sponsors to candidates (1-2 sponsors per candidate)
            if ($sponsorUsers->count() > 0) {
                $numSponsors = rand(1, min(2, $sponsorUsers->count()));
                $selectedSponsors = $sponsorUsers->random($numSponsors);
                
                foreach ($selectedSponsors as $sponsorUser) {
                    $sponsor = $sponsorUser->sponsor;
                    if ($sponsor && $sponsor->canTakeMoreCandidates()) {
                        $sponsor->addCandidate($candidate, [
                            'start_date' => now()->subDays(rand(1, 30)),
                            'notes' => 'Initial sponsorship assignment',
                        ]);
                    }
                }
            }
        }
    }
}
