<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'doctor_certificate',
        'doctor_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
            'doctor_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Site administrator (staff), able to review doctor applications.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * A doctor whose certificate has been approved by an admin.
     * Only verified doctors get the "Doctor" badge.
     */
    public function isDoctor(): bool
    {
        return $this->role === 'doctor' && $this->doctor_verified_at !== null;
    }

    /**
     * Registered as a doctor but still waiting for admin approval.
     */
    public function isPendingDoctor(): bool
    {
        return $this->role === 'doctor' && $this->doctor_verified_at === null;
    }
}
