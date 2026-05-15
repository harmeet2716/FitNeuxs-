<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modality extends Model
{
    use HasFactory;

    // protected $connection = 'mongodb';

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'color',
        'description',
    ];
}
