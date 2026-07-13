<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'images',
        'is_published',
        'tags',
        'order_column',
    ];

    protected $casts = [
        'images' => 'array',
        'tags' => 'array',
        'is_published' => 'boolean',
    ];
}
