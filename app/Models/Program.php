<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'goal',
        'duration_weeks',
        'difficulty',
        'summary',
    ];

    public function workouts(): HasMany
    {
        return $this->hasMany(Workout::class);
    }
}
