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
