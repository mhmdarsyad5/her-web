<?php

namespace App\Filament\Resources\Leads\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LeadInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Pelanggan')
                ->columns(2)
                ->schema([
                    TextEntry::make('name')
                        ->label('Nama Lengkap'),

                    TextEntry::make('company_name')
                        ->label('Nama Perusahaan')
                        ->placeholder('-'),

                    TextEntry::make('email')
                        ->label('Email'),

                    TextEntry::make('whatsapp_number')
                        ->label('Nomor WhatsApp'),
                ]),

            Section::make('Spesifikasi Kebutuhan & Rekomendasi')
                ->columns(2)
                ->schema([
                    TextEntry::make('industry')
                        ->label('Sektor Industri'),

                    TextEntry::make('location')
                        ->label('Lokasi Kota'),

                    TextEntry::make('requested_load_capacity')
                        ->label('Kapasitas Beban (kg)')
                        ->numeric(),

                    TextEntry::make('requested_lift_height')
                        ->label('Tinggi Angkat (meter)'),

                    TextEntry::make('recommended_products')
                        ->label('Unit Rekomendasi')
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
