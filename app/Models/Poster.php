<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poster extends Model
{
    protected $fillable = ['title', 'description', 'photos', 'price'];

    protected $casts = [
        'photos' => 'array',
    ];
}
