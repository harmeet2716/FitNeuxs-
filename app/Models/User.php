<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'profile_photo_path',
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
        ];
    }
    public function fitnessProfile()
    {
        return $this->hasOne(\App\Models\FitnessProfile::class);
    }

    public function userProgram()
    {
        return $this->hasOne(\App\Models\UserProgram::class);
    }

    public function selectedProgram()
    {
        return $this->hasOneThrough(
            \App\Models\Program::class,
            \App\Models\UserProgram::class,
            'user_id',
            'id',
            'id',
            'program_id'
        );
    }

    public function progress()
    {
        return $this->hasMany(\App\Models\UserProgress::class);
    }
}
