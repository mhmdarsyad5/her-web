<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
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
            try {
                $admins = \App\Models\User::all();

                \Filament\Notifications\Notification::make()
                    ->title('Pesan Masuk Baru ✉️')
                    ->body("Dari {$message->name}: \"".\Illuminate\Support\Str::limit($message->subject ?? $message->message, 50).'"')
                    ->icon('heroicon-o-envelope')
                    ->iconColor('success')
                    ->actions([
                        \Filament\Actions\Action::make('view')
                            ->label('Lihat Pesan')
                            ->button()
                            ->url(\App\Filament\Resources\ContactMessages\ContactMessageResource::getUrl('view', ['record' => $message->id])),
                    ])
                    ->sendToDatabase($admins);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Gagal mengirim notifikasi pesan masuk: '.$e->getMessage());
            }
        });
    }
}
