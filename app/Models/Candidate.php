<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'status',
        'rejection_reason',
        'notes',
        'user_id',
        'application_date',
        'status_updated_at',
        'total_score',
        'evaluations_count',
        'address',
        'city',
        'country',
        'postal_code',
        'date_of_birth',
        'gender',
        'biography'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['notes.user', 'addedBy'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'application_date' => 'date',
        'status_updated_at' => 'date',
        'total_score' => 'integer',
        'evaluations_count' => 'integer',
    ];

    /**
     * Get the user that owns the candidate.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the user who added this candidate.
     */
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    /**
     * Get all notes for the candidate.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(CandidateNote::class)->with('user')->latest();
    }
    
    /**
     * Get the notes relationship with a fallback to an empty collection.
     */
    public function getNotesAttribute($value)
    {
        if (!array_key_exists('notes', $this->relations)) {
            $this->load('notes');
        }
        
        return $this->getRelationValue('notes') ?? collect();
    }

    /**
     * The sponsors that belong to the candidate.
     */
    public function sponsors(): BelongsToMany
    {
        return $this->belongsToMany(Sponsor::class, 'sponsor_candidate')
            ->withPivot(['status', 'start_date', 'end_date', 'notes'])
            ->withTimestamps();
    }

    /**
     * Get all evaluations for the candidate.
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * Get the average rating for the candidate.
     */
    public function getAverageRatingAttribute(): float
    {
        return $this->evaluations()->avg('overall_rating') ?? 0;
    }

    /**
     * Get the number of evaluations for the candidate.
     */
    public function getEvaluationCountAttribute(): int
    {
        return $this->evaluations()->count();
    }

    /**
     * Scope a query to only include candidates with a specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Mark the candidate as accepted.
     */
    public function markAsAccepted(): void
    {
        $this->update([
            'status' => 'accepted',
            'status_updated_at' => now(),
        ]);
    }

    /**
     * Mark the candidate as rejected.
     */
    public function markAsRejected(string $reason = null): void
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'status_updated_at' => now(),
        ]);
    }

    /**
     * Check if the candidate is pending review.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the candidate is under review.
     */
    public function isUnderReview(): bool
    {
        return $this->status === 'under_review';
    }

    /**
     * Check if the candidate is accepted.
     */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    /**
     * Check if the candidate is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}
