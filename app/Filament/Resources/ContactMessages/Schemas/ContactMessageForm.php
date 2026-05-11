<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required(),

                TextInput::make('whatsapp_number')
                    ->label('WhatsApp Number')
                    ->placeholder('+628123456789')
                    ->tel() // input type="tel"
                    ->required(),

                TextInput::make('subject')
                    ->required(),

                Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
