<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'button_text',
        'button_url',
    ];

    protected $casts = [
        'image' => 'array',
    ];
}
