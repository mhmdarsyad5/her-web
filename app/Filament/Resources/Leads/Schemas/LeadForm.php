<?php

namespace App\Filament\Resources\Leads\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Pelanggan')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->disabled(),

                    TextInput::make('company_name')
                        ->label('Nama Perusahaan')
                        ->disabled(),

                    TextInput::make('email')
                        ->label('Email')
                        ->disabled(),

                    TextInput::make('whatsapp_number')
                        ->label('Nomor WhatsApp')
                        ->disabled(),
                ]),

            Section::make('Spesifikasi Kebutuhan & Rekomendasi')
                ->columns(2)
                ->schema([
                    TextInput::make('industry')
                        ->label('Sektor Industri')
                        ->disabled(),

                    TextInput::make('location')
                        ->label('Lokasi Kota')
                        ->disabled(),

                    TextInput::make('requested_load_capacity')
                        ->label('Kapasitas Beban (kg)')
                        ->disabled(),

                    TextInput::make('requested_lift_height')
                        ->label('Tinggi Angkat (meter)')
                        ->disabled(),

                    Textarea::make('recommended_products')
                        ->label('Unit Rekomendasi')
                        ->disabled()
                        ->columnSpanFull()
                        ->formatStateUsing(function ($state) {
                            if (is_array($state)) {
                                return implode("\n", array_map(fn ($p) => '- '.($p['name'] ?? ''), $state));
                            }

                            return $state;
                        }),
                ]),
        ]);
    }
}
