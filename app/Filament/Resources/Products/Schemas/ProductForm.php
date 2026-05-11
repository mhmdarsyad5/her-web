<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
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
