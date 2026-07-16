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
        'secondary_button_text',
        'secondary_button_url',
        'key_points',
    ];

    protected $casts = [
        'image' => 'array',
        'key_points' => 'array',
    ];
}
