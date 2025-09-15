<?php

namespace Database\Seeders;

use App\Models\Evaluation;
use App\Models\Game;
use App\Models\Sponsor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsors = Sponsor::with('user')->get();
        
        // Get admin user (first user with admin role or first user if none found)
        $admin = User::whereHas('roles', function($q) {
            $q->where('name', 'admin');
        })->first();
        
        if (!$admin) {
            $admin = User::first();
        }
        
        // Create past games
        for ($i = 1; $i <= 5; $i++) {
            $startDate = now()->subDays(rand(5, 60))->setTime(10, 0, 0);
            $endDate = (clone $startDate)->addHours(4);
            
            $game = Game::create([
                'name' => 'ZIMA Game Day #' . $i,
                'location' => 'ZIMA Airsoft Field, ' . 
                    rand(1, 100) . ' ' . 
                    collect(['Forest', 'Mountain', 'Urban', 'Desert', 'Industrial'])->random() . ' ' .
                    collect(['Zone', 'Sector', 'Area', 'Field'])->random(),
                'start_datetime' => $startDate,
                'end_datetime' => $endDate,
                'description' => 'Regular ZIMA airsoft game day with various scenarios and objectives.',
                'status' => 'completed',
                'max_participants' => rand(20, 50),
                'is_private' => false,
                'created_by' => $admin->id,
                'notes' => 'Game completed successfully.',
            ]);
            
            // Create evaluations for this game
            $this->createEvaluationsForGame($game, $sponsors);
        }
        
        // Create upcoming games
        for ($i = 1; $i <= 3; $i++) {
            $startDate = now()->addDays(rand(7, 30))->setTime(10, 0, 0);
            $endDate = (clone $startDate)->addHours(4);
            
            Game::create([
                'name' => 'ZIMA Upcoming Game #' . $i,
                'location' => 'ZIMA Airsoft Field, ' . 
                    rand(1, 100) . ' ' . 
                    collect(['Forest', 'Mountain', 'Urban', 'Desert', 'Industrial'])->random() . ' ' .
                    collect(['Zone', 'Sector', 'Area', 'Field'])->random(),
                'start_datetime' => $startDate,
                'end_datetime' => $endDate,
                'description' => 'Upcoming ZIMA airsoft game day. Prepare your gear and get ready for action!',
                'status' => 'scheduled',
                'max_participants' => rand(20, 50),
                'is_private' => $i === 3, // Make the 3rd game private
                'created_by' => $admin->id,
                'notes' => 'Game preparation in progress.',
            ]);
        }
    }
    
    /**
     * Create evaluations for a game
     */
    private function createEvaluationsForGame(Game $game, $sponsors): void
    {
        foreach ($sponsors as $sponsor) {
            $candidates = $sponsor->candidates()
                ->wherePivot('status', 'active')
                ->get();
                
            foreach ($candidates as $candidate) {
                // Only create evaluations for some candidates (70% chance)
                if (rand(1, 10) <= 7) {
                    $this->createEvaluation($game, $sponsor, $candidate);
                }
            }
        }
    }
    
    /**
     * Create a single evaluation
     */
    private function createEvaluation(Game $game, $sponsor, $candidate): void
    {
        $ratings = [
            'teamwork_rating' => rand(3, 5),
            'strategy_rating' => rand(2, 5),
            'marksmanship_rating' => rand(2, 5),
            'sportsmanship_rating' => rand(3, 5),
            'communication_rating' => rand(2, 5),
        ];
        
        $overallRating = array_sum($ratings) / count($ratings);
        
        $evaluation = Evaluation::create([
            'sponsor_id' => $sponsor->id,
            'candidate_id' => $candidate->id,
            'game_id' => $game->id,
            'evaluation_date' => $game->start_datetime->addHours(rand(1, 3)),
            'is_finalized' => true,
            'finalized_at' => $game->start_datetime->addHours(4),
            'overall_rating' => $overallRating,
            'strengths' => $this->generateRandomStrengths($ratings),
            'areas_for_improvement' => $this->generateRandomImprovements($ratings),
            'additional_notes' => collect([
                'Candidate performed well overall.',
                'Good potential shown.',
                'Needs more experience in team play.',
                'Excellent communication skills.',
                'Showed good tactical awareness.',
                'Needs to work on accuracy.',
                'Great team player.',
                'Demonstrated leadership potential.',
            ])->random(rand(1, 3))->implode(' '),
            ...$ratings,
        ]);
        
        // Update candidate's evaluation count and total score
        $candidate->increment('evaluations_count');
        $candidate->increment('total_score', $overallRating);
        
        // Update candidate status based on evaluations
        if ($candidate->evaluations_count >= 3 && $candidate->status === 'pending') {
            $candidate->update([
                'status' => 'under_review',
                'status_updated_at' => now(),
            ]);
        }
    }
    
    /**
     * Generate random strengths based on ratings
     */
    private function generateRandomStrengths(array $ratings): string
    {
        $strengths = [];
        $categories = [
            'teamwork_rating' => 'Teamwork',
            'strategy_rating' => 'Strategic thinking',
            'marksmanship_rating' => 'Marksmanship',
            'sportsmanship_rating' => 'Sportsmanship',
            'communication_rating' => 'Communication',
        ];
        
        foreach ($ratings as $key => $rating) {
            if ($rating >= 4) {
                $strengths[] = $categories[$key];
            }
        }
        
        if (empty($strengths)) {
            return 'No significant strengths identified yet.';
        }
        
        return 'Strong points: ' . implode(', ', $strengths) . '.';
    }
    
    /**
     * Generate random areas for improvement based on ratings
     */
    private function generateRandomImprovements(array $ratings): string
    {
        $improvements = [];
        $categories = [
            'teamwork_rating' => 'Teamwork',
            'strategy_rating' => 'Strategic thinking',
            'marksmanship_rating' => 'Marksmanship',
            'sportsmanship_rating' => 'Sportsmanship',
            'communication_rating' => 'Communication',
        ];
        
        foreach ($ratings as $key => $rating) {
            if ($rating <= 3) {
                $improvements[] = $categories[$key];
            }
        }
        
        if (empty($improvements)) {
            return 'No major areas for improvement identified.';
        }
        
        $suggestions = [
            'Consider working on: ',
            'Areas to improve: ',
            'Could benefit from: ',
            'Needs development in: ',
            'Should focus on: ',
        ];
        
        return $suggestions[array_rand($suggestions)] . implode(', ', $improvements) . '.';
    }
}
