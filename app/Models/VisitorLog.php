<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class VisitorLog extends Model
{
    use HasFactory, Prunable;

    protected $fillable = [
        'ip_address',
        'url',
        'method',
        'user_agent',
        'city',
        'region',
        'country',
    ];

    /**
     * Get the prunable model query.
     */
    public function prunable()
    {
        return static::where('created_at', '<', now()->subDays(90));
    }
}
