<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidate = Candidate::find(6);
        $user = User::first();

        if ($candidate && $user) {
            $candidate->notes()->create([
                'user_id' => $user->id,
                'content' => 'This is a test note added by the system.',
                'is_private' => false,
            ]);
            
            $this->command->info('Test note added successfully.');
        } else {
            $this->command->error('Could not find candidate or user.');
        }
    }
}
