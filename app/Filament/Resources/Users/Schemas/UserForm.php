<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Select::make('roles')
                    ->label('Role')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable()
                    ->helperText('Pilih satu atau lebih role untuk user ini'),
                DateTimePicker::make('email_verified_at')
                    ->hidden(),
                TextInput::make('password')
                    ->password()
                    ->label('Password baru (biarkan kosong jika tidak ganti)')
                    ->required(fn(string $operation) => $operation === 'create')
                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn($state) => filled($state)),

            ]);
    }
}
