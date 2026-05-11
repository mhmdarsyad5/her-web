<?php

namespace App\Filament\Resources\HeroSections\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class HeroSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Hero Title')
                    ->required(),

                Textarea::make('description')
                    ->label('Hero Description')
                    ->columnSpanFull(),

                TextInput::make('button_text')
                    ->label('Button Text'),

                FileUpload::make('image')
                    ->label('Hero Image')
                    ->image()
                    ->disk('public')
                    ->directory('hero')
                    ->preserveFilenames()
                    ->enableOpen()
                    ->enableDownload()
                    ->columnSpanFull(),

                TextInput::make('button_url')
                    ->label('Button URL'),
            ]);
    }
}
