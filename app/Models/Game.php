<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'location',
        'start_datetime',
        'end_datetime',
        'description',
        'status',
        'max_participants',
        'is_private',
        'created_by',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'max_participants' => 'integer',
        'is_private' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @deprecated Use the "casts" property
     *
     * @var array
     */
    protected $dates = [
        'start_datetime',
        'end_datetime',
        'deleted_at',
    ];

    /**
     * The user who created the game.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all evaluations for this game.
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * Scope a query to only include upcoming games.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_datetime', '>', now())
                    ->where('status', 'scheduled')
                    ->orderBy('start_datetime');
    }

    /**
     * Scope a query to only include past games.
     */
    public function scopePast($query)
    {
        return $query->where('end_datetime', '<', now())
                    ->orderBy('start_datetime', 'desc');
    }

    /**
     * Scope a query to only include active games.
     */
    public function scopeActive($query)
    {
        $now = now();
        return $query->where('start_datetime', '<=', $now)
                    ->where('end_datetime', '>=', $now)
                    ->where('status', 'in_progress')
                    ->orderBy('start_datetime');
    }

    /**
     * Check if the game is upcoming.
     */
    public function isUpcoming(): bool
    {
        return $this->start_datetime->isFuture() && $this->status === 'scheduled';
    }

    /**
     * Check if the game is currently active.
     */
    public function isActive(): bool
    {
        $now = now();
        return $this->start_datetime <= $now && 
               $this->end_datetime >= $now && 
               $this->status === 'in_progress';
    }

    /**
     * Check if the game is in the past.
     */
    public function isPast(): bool
    {
        return $this->end_datetime->isPast();
    }

    /**
     * Check if the game is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Get the duration of the game in minutes.
     */
    public function getDurationInMinutes(): int
    {
        return $this->start_datetime->diffInMinutes($this->end_datetime);
    }

    /**
     * Get the number of evaluations submitted for this game.
     */
    public function getEvaluationCountAttribute(): int
    {
        return $this->evaluations()->count();
    }

    /**
     * Mark the game as in progress.
     */
    public function markAsInProgress(): bool
    {
        return $this->update(['status' => 'in_progress']);
    }

    /**
     * Mark the game as completed.
     */
    public function markAsCompleted(): bool
    {
        return $this->update(['status' => 'completed']);
    }

    /**
     * Cancel the game.
     */
    public function cancel(string $reason = null): bool
    {
        return $this->update([
            'status' => 'cancelled',
            'notes' => $reason ? ($this->notes ? $this->notes . "\n\nCancellation reason: " . $reason : 'Cancellation reason: ' . $reason) : $this->notes,
        ]);
    }

    /**
     * Get the location as a Google Maps link.
     */
    public function getGoogleMapsLink(): string
    {
        return 'https://www.google.com/maps/search/?api=1&query=' . urlencode($this->location);
    }
}
