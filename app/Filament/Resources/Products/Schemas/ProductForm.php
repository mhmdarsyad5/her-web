<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // SECTION 1: INFORMASI UTAMA
                Section::make('Informasi Utama Produk')
                    ->description('Isi data nama, deskripsi, dan tipe segmen produk.')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name_id')
                                ->label('Nama Produk')
                                ->placeholder('Contoh: Forklift Diesel 3 Ton')
                                ->required()
                                ->maxLength(150)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $set('slug', Str::slug($state));
                                })
                                ->columnSpanFull(),

                            Textarea::make('description_id')
                                ->label('Deskripsi Produk')
                                ->rows(4)
                                ->placeholder('Tuliskan deskripsi produk...')
                                ->columnSpanFull(),

                            TextInput::make('tagline')
                                ->label('Tagline Singkat')
                                ->placeholder('Contoh: Cocok untuk logistik gudang kecil dengan koridor sempit')
                                ->maxLength(255)
                                ->columnSpanFull(),

                            Select::make('product_type')
                                ->label('Tipe / Segmen Produk')
                                ->options(fn () => \App\Models\ProductType::where('is_active', true)->orderBy('sort_order')->pluck('name', 'slug'))
                                ->placeholder('Pilih tipe segmen produk...')
                                ->required(),

                            TextInput::make('energy_type')
                                ->label('Tipe Energi')
                                ->placeholder('Contoh: Lithium-Ion / Diesel / Gasoline / -')
                                ->maxLength(100),

                            TextInput::make('slug')
                                ->label('Slug URL')
                                ->placeholder('Akan terisi otomatis dari Nama Produk')
                                ->required()
                                ->columnSpanFull(),

                            \App\Support\FilamentImagePicker::make(
                                fieldName: 'images',
                                label: 'Gambar Produk',
                                directory: 'products',
                                prefix: 'product',
                                multiple: true,
                                helperText: 'Pilih dari galeri atau upload baru. Maks: 5MB per file.'
                            )->columnSpanFull(),
                        ]),
                    ]),

                // SECTION 2: KRITERIA REKOMENDASI (SISTEM REKOMENDASI)
                Section::make('Kriteria Rekomendasi')
                    ->description('Isi data spesifikasi angka murni di bawah ini agar produk dapat dicocokkan secara otomatis.')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('dssCriteria')
                                ->multiple()
                                ->relationship(
                                    name: 'dssCriteria',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn ($query) => $query->where('field_type', 'industry')->where('code', '!=', 'others')
                                )
                                ->label('Kesesuaian Sektor Industri')
                                ->placeholder('Pilih satu atau beberapa industri...')
                                ->preload()
                                ->columnSpanFull(),

                            TextInput::make('max_lift_height_mm')
                                ->label('Tinggi Angkat Maks (mm)')
                                ->numeric()
                                ->placeholder('Contoh: 6000')
                                ->helperText('Satuan milimeter. Contoh: 6m = 6000'),

                            TextInput::make('max_capacity_kg')
                                ->label('Kapasitas Beban Max (kg)')
                                ->numeric()
                                ->placeholder('Contoh: 3800')
                                ->helperText('Satuan kg. Contoh: 3.8 Ton = 3800'),

                            TextInput::make('min_capacity_kg')
                                ->label('Kapasitas Beban Min (kg)')
                                ->numeric()
                                ->placeholder('Contoh: 1500')
                                ->helperText('Satuan kg. Kosongkan jika tidak ada batas minimal.'),
                        ]),
                    ]),

                // SECTION 3: SPESIFIKASI TAMPILAN
                Section::make('Teks Spesifikasi')
                    ->description('Teks ini hanya digunakan untuk tampilan visual di halaman produk.')
                    ->collapsible()
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('lift_height')
                                ->label('Tinggi Angkat (Teks Tampilan)')
                                ->placeholder('Contoh: 3.0 - 6.0 m atau 3.0 m')
                                ->maxLength(100),

                            TextInput::make('load_capacity')
                                ->label('Kapasitas Beban (Teks Tampilan)')
                                ->placeholder('Contoh: 1.5 - 3.8 ton atau 3 ton')
                                ->maxLength(100),

                            TextInput::make('operator_type')
                                ->label('Tipe Operator (Teks Tampilan)')
                                ->placeholder('Contoh: Seated / Stand-on')
                                ->maxLength(100),
                        ]),
                    ]),

                // SECTION 4: INFORMASI HARGA
                Section::make('Informasi Harga Sewa/Jual')
                    ->description('Tentukan harga normal dan harga promo produk.')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('price')
                                ->label('Harga Normal')
                                ->numeric()
                                ->required()
                                ->default(0)
                                ->prefix('Rp')
                                ->placeholder('15000')
                                ->helperText('Harga normal produk sebelum promo.'),

                            TextInput::make('sale_price')
                                ->label('Harga Promo')
                                ->numeric()
                                ->prefix('Rp')
                                ->placeholder('12000')
                                ->helperText('Opsional. Isi jika produk sedang promo.'),
                        ]),
                    ]),

                // SECTION 5: SPESIFIKASI LENGKAP & PENGATURAN TAMPILAN
                Section::make('Spesifikasi Detil & Pengaturan Tampilan')
                    ->description('Kelola parameter spesifikasi lengkap dan urutan tampil produk.')
                    ->collapsible()
                    ->schema([
                        Repeater::make('specifications')
                            ->label('Spesifikasi Lengkap (Parameter Brosur)')
                            ->schema([
                                TextInput::make('key')
                                    ->label('Nama Parameter')
                                    ->placeholder('Contoh: Travel Speed, Turning Radius')
                                    ->required(),
                                TextInput::make('value')
                                    ->label('Nilai (Value)')
                                    ->placeholder('Contoh: 17km/h, 2200mm, Seated')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->collapsible()
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string => $state['key'] ?? null)
                            ->createItemButtonLabel('Tambah Baris Spesifikasi Baru'),

                        Grid::make(3)->schema([
                            Toggle::make('is_active')
                                ->label('Status Aktif')
                                ->default(true)
                                ->helperText('Nonaktifkan jika produk sedang tidak disewakan/ditampilkan.'),

                            Toggle::make('is_featured')
                                ->label('Rekomendasi Utama')
                                ->default(false)
                                ->helperText('Tampilkan badge Rekomendasi Utama pada hasil pencarian DSS.'),

                            TextInput::make('sort_order')
                                ->label('Urutan Tampil')
                                ->numeric()
                                ->default(0)
                                ->placeholder('0')
                                ->helperText('Semakin kecil nilainya, semakin atas posisi tampilannya di katalog.'),
                        ]),
                    ]),
            ]);
    }
}
