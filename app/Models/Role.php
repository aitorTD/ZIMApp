<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Scope a query to only include roles with the given name.
     */
    public function scopeNamed($query, $name)
    {
        return $query->where('name', $name);
    }

    /**
     * Check if the role is an admin role.
     */
    public function isAdmin(): bool
    {
        return $this->name === 'admin';
    }

    /**
     * Check if the role is a sponsor role.
     */
    public function isSponsor(): bool
    {
        return $this->name === 'sponsor';
    }

    /**
     * Check if the role is a member role.
     */
    public function isMember(): bool
    {
        return $this->name === 'member';
    }

    /**
     * Check if the role is a candidate role.
     */
    public function isCandidate(): bool
    {
        return $this->name === 'candidate';
    }
}
