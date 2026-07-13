<?php

namespace App\Jobs;

use App\Models\ContactMessage;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Str;

class SendContactMessageNotification implements ShouldQueue
{
    use Queueable;

    public function __construct(public ContactMessage $message) {}

    public function handle(): void
    {
        $admins = User::all();

        Notification::make()
            ->title('Pesan Masuk Baru ✉️')
            ->body("Dari {$this->message->name}: \"".Str::limit($this->message->subject ?? $this->message->message, 50).'"')
            ->icon('heroicon-o-envelope')
            ->iconColor('success')
            ->actions([
                Action::make('view')
                    ->label('Lihat Pesan')
                    ->button()
                    ->url(\App\Filament\Resources\ContactMessages\ContactMessageResource::getUrl('view', ['record' => $this->message->id])),
            ])
            ->sendToDatabase($admins);
    }
}
