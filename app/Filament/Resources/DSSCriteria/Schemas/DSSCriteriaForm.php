<?php

namespace App\Filament\Resources\DSSCriteria\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DSSCriteriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('field_type')
                ->default('industry')
                ->hidden()
                ->required(),

            TextInput::make('code')
                ->label('Kode Kriteria')
                ->placeholder('Contoh: retail, logistics, factory')
                ->required(),

            TextInput::make('name')
                ->label('Nama Industri (Indonesia)')
                ->placeholder('Contoh: Ritel / Grosir, Transportasi / Logistik')
                ->required(),

            TextInput::make('sort_order')
                ->label('Urutan Tampil')
                ->numeric()
                ->default(0),

            Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),
        ]);
    }
}
