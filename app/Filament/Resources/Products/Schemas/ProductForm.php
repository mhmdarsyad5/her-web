<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
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
                    ->options([
                        'electric' => 'Forklift Elektrik',
                        'diesel' => 'Forklift Diesel',
                        'pallet-truck' => 'Pallet Truck',
                        'pallet-stacker' => 'Pallet Stacker',
                        'warehouse' => 'Warehouse Equipment & AGV',
                    ])
                    ->placeholder('Pilih tipe segmen produk...')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('energy_type')
                    ->label('Tipe Energi')
                    ->placeholder('Contoh: Lithium-Ion / Diesel / Gasoline / -')
                    ->maxLength(100)
                    ->columnSpan(1),

                TextInput::make('lift_height')
                    ->label('Tinggi Angkat')
                    ->placeholder('Contoh: 3.0 - 6.0 m')
                    ->maxLength(100)
                    ->columnSpan(1),

                TextInput::make('load_capacity')
                    ->label('Kapasitas Beban')
                    ->placeholder('Contoh: 1.5 - 3.8 ton')
                    ->maxLength(100)
                    ->columnSpan(1),

                TextInput::make('slug')
                    ->label('Slug URL')
                    ->placeholder('Akan terisi otomatis dari Nama Produk')
                    ->required()
                    ->columnSpan(1),

                TextInput::make('price')
                    ->label('Harga Normal')
                    ->numeric()
                    ->required()
                    ->default(0)
                    ->prefix('Rp')
                    ->placeholder('15000')
                    ->helperText('Harga normal produk sebelum promo.')
                    ->columnSpan(1),

                TextInput::make('sale_price')
                    ->label('Harga Promo')
                    ->numeric()
                    ->prefix('Rp')
                    ->placeholder('12000')
                    ->helperText('Opsional. Isi jika produk sedang promo.')
                    ->columnSpan(1),

                FileUpload::make('images')
                    ->label('Gambar Produk')
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('products')
                    ->helperText('Upload satu atau beberapa gambar produk.')
                    ->columnSpanFull(),

                Repeater::make('specifications')
                    ->label('Spesifikasi Lengkap')
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
                    ->createItemButtonLabel('Tambah Spesifikasi Baru'),

                Toggle::make('is_active')
                    ->label('Status Produk')
                    ->default(true)
                    ->helperText('Nonaktifkan untuk menyembunyikan produk.')
                    ->columnSpan(1),

                TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0)
                    ->placeholder('0')
                    ->helperText('Semakin kecil, semakin di atas.')
                    ->columnSpan(1),
            ]);
    }
}
