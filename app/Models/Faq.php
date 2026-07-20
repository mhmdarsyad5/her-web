<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use \App\Traits\LogsModelActivity;
    use HasFactory;

    protected $table = 'faqs';

    protected $fillable = [
        'question',
        'answer',
        'is_published',
        'order_column',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
