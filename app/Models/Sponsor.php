<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsor extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'max_candidates',
        'current_candidates_count',
        'is_active',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'max_candidates' => 'integer',
        'current_candidates_count' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the sponsor.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The candidates that belong to the sponsor.
     */
    public function candidates(): BelongsToMany
    {
        return $this->belongsToMany(Candidate::class, 'sponsor_candidate')
            ->withPivot(['status', 'start_date', 'end_date', 'notes'])
            ->withTimestamps();
    }

    /**
     * Get all evaluations submitted by this sponsor.
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * Check if the sponsor can take on more candidates.
     */
    public function canTakeMoreCandidates(): bool
    {
        return $this->current_candidates_count < $this->max_candidates;
    }

    /**
     * Get the number of available candidate slots.
     */
    public function getAvailableSlotsAttribute(): int
    {
        return max(0, $this->max_candidates - $this->current_candidates_count);
    }

    /**
     * Get the active candidates count for this sponsor.
     */
    public function getActiveCandidatesCountAttribute(): int
    {
        return $this->candidates()
            ->wherePivot('status', 'active')
            ->count();
    }

    /**
     * Scope a query to only include active sponsors.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Add a candidate to this sponsor.
     */
    public function addCandidate(Candidate $candidate, array $pivotAttributes = []): void
    {
        $this->candidates()->attach($candidate, array_merge([
            'status' => 'active',
            'start_date' => now(),
        ], $pivotAttributes));

        $this->increment('current_candidates_count');
    }

    /**
     * Remove a candidate from this sponsor.
     */
    public function removeCandidate(Candidate $candidate, string $reason = null): void
    {
        $this->candidates()->updateExistingPivot($candidate->id, [
            'status' => 'withdrawn',
            'end_date' => now(),
            'notes' => $reason,
        ]);

        $this->decrement('current_candidates_count');
    }
}
