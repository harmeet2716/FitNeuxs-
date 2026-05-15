<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkoutSession extends Model
{
    use HasFactory;

    // protected $connection = 'mongodb'; // Enable when MongoDB extension is active

    protected $fillable = [
        'user_id',
        'type',
        'exercises',
        'start_time',
        'end_time',
        'total_volume',
        'status',
    ];

    protected $casts = [
        'exercises' => 'array',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'total_volume' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
