<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'address',
        'city',
        'country',
        'postal_code',
        'membership_status',
        'profile_image',
        'biography',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * Get the candidates that this user is sponsoring
     */
    public function sponsoredCandidates()
    {
        return $this->belongsToMany(User::class, 'candidate_sponsor', 'sponsor_id', 'candidate_id')
            ->withPivot('status', 'notes')
            ->withTimestamps()
            ->using(CandidateSponsor::class);
    }

    /**
     * Get the sponsors for this candidate
     */
    public function sponsors()
    {
        return $this->belongsToMany(User::class, 'candidate_sponsor', 'candidate_id', 'sponsor_id')
            ->withPivot('status', 'notes')
            ->withTimestamps()
            ->using(CandidateSponsor::class);
    }

    /**
     * Check if the user is a sponsor
     */
    public function isSponsor()
    {
        return $this->hasRole('member') || $this->hasRole('sponsor');
    }

    /**
     * Check if the user is a candidate
     */
    public function isCandidate()
    {
        return $this->hasRole('candidate');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
        ];
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Role-related methods are provided by the HasRoles trait from Spatie

    /**
     * Get the candidate record associated with the user.
     */
    public function candidate()
    {
        return $this->hasOne(Candidate::class);
    }

    /**
     * Get the sponsor record associated with the user.
     */
    public function sponsor()
    {
        return $this->hasOne(Sponsor::class);
    }

    /**
     * Get the games created by this user.
     */
    public function createdGames()
    {
        return $this->hasMany(Game::class, 'created_by');
    }

    /**
     * Get the evaluations submitted by this user (if they are a sponsor).
     */
    public function evaluations()
    {
        return $this->hasManyThrough(
            Evaluation::class,
            Sponsor::class,
            'user_id',
            'sponsor_id',
            'id',
            'id'
        );
    }
}
