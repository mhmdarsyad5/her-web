<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reply_whatsapp')
                ->label('Balas via WhatsApp')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('success')
                ->url(function () {
                    $record = $this->getRecord();
                    $phone = preg_replace('/[^0-9]/', '', $record->whatsapp_number);
                    if (str_starts_with($phone, '0')) {
                        $phone = '62'.substr($phone, 1);
                    }

                    $text = 'Halo '.$record->name.",\n\nTerima kasih telah menghubungi kami melalui website Herro Equipment Rentals.\n\nAda yang bisa kami bantu?";

                    return "https://wa.me/{$phone}?text=".urlencode($text);
                })
                ->openUrlInNewTab(),

            Action::make('reply_email')
                ->label('Balas via Email')
                ->icon('heroicon-o-envelope')
                ->color('info')
                ->url(function () {
                    $record = $this->getRecord();
                    $subject = urlencode('Balasan: '.($record->subject ?? 'Pesan Website Herro'));
                    $body = urlencode('Halo '.$record->name.",\n\nTerima kasih telah menghubungi kami.\n\n");

                    return "mailto:{$record->email}?subject={$subject}&body={$body}";
                })
                ->openUrlInNewTab(),
        ];
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);

        if (! $this->getRecord()->is_read) {
            $this->getRecord()->update(['is_read' => true]);
        }
    }
}
