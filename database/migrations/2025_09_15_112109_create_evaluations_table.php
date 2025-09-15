<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->onDelete('cascade');
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            
            // Performance ratings (1-5 scale)
            $table->tinyInteger('teamwork_rating');
            $table->tinyInteger('strategy_rating');
            $table->tinyInteger('marksmanship_rating');
            $table->tinyInteger('sportsmanship_rating');
            $table->tinyInteger('communication_rating');
            
            // Overall assessment
            $table->decimal('overall_rating', 3, 1);
            $table->text('strengths')->nullable();
            $table->text('areas_for_improvement')->nullable();
            $table->text('additional_notes')->nullable();
            
            // Evaluation metadata
            $table->date('evaluation_date');
            $table->boolean('is_finalized')->default(false);
            $table->timestamp('finalized_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Ensure a sponsor can only evaluate a candidate once per game
            $table->unique(['sponsor_id', 'candidate_id', 'game_id'], 'unique_evaluation_per_game');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
