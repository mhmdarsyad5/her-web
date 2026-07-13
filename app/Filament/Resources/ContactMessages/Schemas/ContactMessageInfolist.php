<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContactMessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nama Pengirim'),
                TextEntry::make('email')
                    ->label('Alamat Email'),
                TextEntry::make('whatsapp_number')
                    ->label('Nomor WhatsApp'),
                TextEntry::make('subject')
                    ->label('Subjek')
                    ->placeholder('-'),
                TextEntry::make('message')
                    ->label('Isi Pesan')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Diterima Pada')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
