<?php

namespace App\Filament\Resources\Services\Schemas;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([

                /* =====================
                 * SERVICE NAME & DESCRIPTION
                 * ===================== */
                TextInput::make('name')
                    ->label('Service Name')
                    ->placeholder('Contoh: Jasa Rental Alat Berat')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    })
                    ->columnSpanFull(),

                TinyEditor::make('description')
                    ->label('Description')
                    ->placeholder('Tulis penjelasan lengkap tentang layanan...')
                    ->columnSpanFull(),

                /* =====================
                 * SLUG
                 * ===================== */
                TextInput::make('slug')
                    ->label('Slug URL')
                    ->placeholder('Akan terisi otomatis dari nama')
                    ->required()
                    ->columnSpan(1),

                /* =====================
                 * MEDIA
                 * ===================== */
                FileUpload::make('icon')
                    ->label('Icon')
                    ->directory('services/icons')
                    ->image()
                    ->disk('public')
                    ->maxSize(5120) // 5MB
                    ->optimizeToWebp(600, 90)
                    ->helperText('Icon layanan (PNG / SVG). Maks: 5MB.')
                    ->columnSpan(1),

                FileUpload::make('image')
                    ->label('Thumbnail / Featured Image')
                    ->directory('services')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->maxSize(5120) // 5MB
                    ->optimizeToWebp(1200, 80)
                    ->helperText('Gambar utama layanan. Maks: 5MB.')
                    ->columnSpan(1),

                /* =====================
                 * STATUS & SORT
                 * ===================== */
                Toggle::make('is_active')
                    ->label('Active?')
                    ->default(true)
                    ->helperText('Nonaktifkan untuk menyembunyikan layanan.')
                    ->columnSpan(1),

                TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0)
                    ->helperText('Semakin kecil, semakin di atas.')
                    ->columnSpan(1),
            ]);
    }
}
