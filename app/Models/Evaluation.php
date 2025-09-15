<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluation extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sponsor_id',
        'candidate_id',
        'game_id',
        'teamwork_rating',
        'strategy_rating',
        'marksmanship_rating',
        'sportsmanship_rating',
        'communication_rating',
        'overall_rating',
        'strengths',
        'areas_for_improvement',
        'additional_notes',
        'evaluation_date',
        'is_finalized',
        'finalized_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'evaluation_date' => 'date',
        'is_finalized' => 'boolean',
        'finalized_at' => 'datetime',
        'teamwork_rating' => 'integer',
        'strategy_rating' => 'integer',
        'marksmanship_rating' => 'integer',
        'sportsmanship_rating' => 'integer',
        'communication_rating' => 'integer',
        'overall_rating' => 'decimal:1',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @deprecated Use the "casts" property
     *
     * @var array
     */
    protected $dates = [
        'evaluation_date',
        'finalized_at',
        'deleted_at',
    ];

    /**
     * The sponsor that submitted the evaluation.
     */
    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }

    /**
     * The candidate that was evaluated.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    /**
     * The game during which the evaluation was made.
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Calculate the overall rating based on individual ratings.
     */
    public function calculateOverallRating(): float
    {
        $ratings = [
            $this->teamwork_rating,
            $this->strategy_rating,
            $this->marksmanship_rating,
            $this->sportsmanship_rating,
            $this->communication_rating,
        ];

        return round(array_sum($ratings) / count($ratings), 1);
    }

    /**
     * Finalize the evaluation.
     */
    public function finalize(): bool
    {
        if ($this->is_finalized) {
            return true;
        }

        return $this->update([
            'is_finalized' => true,
            'finalized_at' => now(),
            'overall_rating' => $this->calculateOverallRating(),
        ]);
    }

    /**
     * Check if the evaluation is finalized.
     */
    public function isFinalized(): bool
    {
        return $this->is_finalized === true;
    }

    /**
     * Scope a query to only include finalized evaluations.
     */
    public function scopeFinalized($query)
    {
        return $query->where('is_finalized', true);
    }

    /**
     * Scope a query to only include draft evaluations.
     */
    public function scopeDraft($query)
    {
        return $query->where('is_finalized', false);
    }

    /**
     * Get the evaluation criteria with their ratings.
     */
    public function getEvaluationCriteria(): array
    {
        return [
            'Teamwork' => $this->teamwork_rating,
            'Strategy' => $this->strategy_rating,
            'Marksmanship' => $this->marksmanship_rating,
            'Sportsmanship' => $this->sportsmanship_rating,
            'Communication' => $this->communication_rating,
        ];
    }
}
