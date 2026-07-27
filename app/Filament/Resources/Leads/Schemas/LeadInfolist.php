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
                        ->html()
                        ->state(function (\App\Models\Lead $record) {
                            $products = $record->recommended_products;
                            if (is_array($products)) {
                                $listItems = array_map(function ($p) {
                                    $name = e($p['name'] ?? '');
                                    if (! empty($p['slug'])) {
                                        $url = url('/produk/'.$p['slug']);

                                        return "<li><a href='{$url}' target='_blank' style='color: #ff7f00; font-weight: bold; text-decoration: underline;'>{$name}</a></li>";
                                    }

                                    return "<li>{$name}</li>";
                                }, $products);

                                return "<ul style='list-style-type: disc; padding-left: 1.5rem;'>".implode('', $listItems).'</ul>';
                            }

                            return '-';
                        }),
                ]),
        ]);
    }
}
