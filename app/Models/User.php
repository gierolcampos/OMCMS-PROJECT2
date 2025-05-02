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
     * @var list<string>
     */
    protected $fillable = [
        'studentnumber',
        'firstname',
        'lastname',
        'middlename',
        'suffix',
        'course',
        'major',
        'year',
        'section',
        'mobile_no',
        'email',
        'password',
        'student_id',
        'course_year_section',
        'membership_type',
        'membership_expiry',
        'alternative_email',
        'department',
        'address',
        'notes',
        'status',
        'user_role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'studentnumber',
        'firstname',
        'lastname',
        'middlename',
        'suffix',
        'course',
        'major',
        'year',
        'section',
        'mobile_no',
        'email',
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
            'membership_expiry' => 'date',
            'status' => 'string',
            'user_role' => 'string',
        ];
    }

    /**
     * Check if the user is an administrator.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->user_role === 'admin';
    }

    /**
     * Check if the user is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return trim($this->firstname . ' ' . ($this->middlename ? $this->middlename . ' ' : '') . $this->lastname . ($this->suffix ? ' ' . $this->suffix : ''));
    }
}
