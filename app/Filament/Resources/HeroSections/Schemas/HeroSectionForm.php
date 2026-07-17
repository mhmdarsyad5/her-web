<?php

namespace App\Filament\Resources\HeroSections\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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

                FileUpload::make('image')
                    ->label('Hero Images')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->disk('public')
                    ->directory('hero')
                    ->maxSize(5120) // 5MB
                    ->optimizeToWebp(1920, 85) // 1920px lebar untuk gambar banner full-width
                    ->helperText('Gambar latar belakang hero banner. Ukuran ideal: 1920x900px. Maks: 5MB per file.')
                    ->enableOpen()
                    ->enableDownload()
                    ->columnSpanFull(),

                TextInput::make('button_text')
                    ->label('Button Kontak Kami Text')
                    ->placeholder('Contoh: Kontak Kami'),

                TextInput::make('button_url')
                    ->label('Button Kontak Kami URL')
                    ->placeholder('Contoh: #contactmessage'),

                TextInput::make('secondary_button_text')
                    ->label('Button Layanan Kami Text')
                    ->placeholder('Contoh: Layanan Kami')
                    ->default('Layanan Kami'),

                TextInput::make('secondary_button_url')
                    ->label('Button Layanan Kami URL')
                    ->placeholder('Contoh: #dssSection')
                    ->default('#dssSection'),

                \Filament\Forms\Components\Repeater::make('key_points')
                    ->label('Poin-Poin Fitur Utama')
                    ->simple(
                        TextInput::make('point')
                            ->placeholder('Contoh: Layanan Rental Forklift Terpercaya & Profesional')
                            ->required()
                    )
                    ->default([
                        'Layanan Rental Forklift Terpercaya & Profesional',
                        'Jaminan Unit Prima & Dukungan Teknisi Siaga',
                        'Pilihan Kapasitas Lengkap (1.5 - 16 Ton)',
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
