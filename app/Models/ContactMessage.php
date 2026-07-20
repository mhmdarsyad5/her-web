<?php

namespace App\Models;

use App\Jobs\SendContactMessageNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use \App\Traits\LogsModelActivity;
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'whatsapp_number',
        'subject',
        'message',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (ContactMessage $message) {
            SendContactMessageNotification::dispatch($message)->afterResponse();
        });
    }
}
