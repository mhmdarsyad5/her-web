<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_name',
        'email',
        'whatsapp_number',
        'industry',
        'location',
        'requested_load_capacity',
        'requested_lift_height',
        'recommended_products',
    ];

    protected $casts = [
        'recommended_products' => 'array',
    ];
}
