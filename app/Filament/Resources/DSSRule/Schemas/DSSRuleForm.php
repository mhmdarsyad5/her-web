<?php

namespace App\Filament\Resources\DSSRule\Schemas;

use App\Models\DSSCriteria;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DSSRuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Produk')
                ->description('Detail produk yang terelasi dengan katalog dan informasi display.')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('product_id')
                            ->label('Relasi Produk Utama')
                            ->relationship('product', 'name_id')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('product_name')
                            ->label('Nama Produk (Display)')
                            ->required()
                            ->maxLength(255),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('category_name')
                            ->label('Kategori')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('brand')
                            ->label('Brand')
                            ->default('HANGCHA')
                            ->placeholder('HANGCHA'),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('model')
                            ->label('Model / Tipe'),
                        TextInput::make('name')
                            ->label('Deskripsi Singkat Rule')
                            ->placeholder('e.g. Lithium Indoor Forklift'),
                    ]),
                ]),

            Section::make('Kriteria Pencocokan (Form SPK 3 Step)')
                ->description('Pilih kriteria yang harus dipenuhi agar produk ini muncul sebagai rekomendasi.')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('conditions.industry')
                            ->label('Jenis Industri (Form 1)')
                            ->multiple()
                            ->options(fn () => DSSCriteria::where('field_type', 'industry')->pluck('name', 'code'))
                            ->searchable()
                            ->required(),

                        Select::make('conditions.product_type')
                            ->label('Jenis Unit Produk (Form 1)')
                            ->multiple()
                            ->options(fn () => DSSCriteria::where('field_type', 'product_type')->pluck('name', 'code'))
                            ->searchable()
                            ->required(),

                        Select::make('conditions.energy')
                            ->label('Sumber Energi / Drive Type (Form 2)')
                            ->options(fn () => DSSCriteria::where('field_type', 'energy')->pluck('name', 'code'))
                            ->searchable()
                            ->required(),

                        Select::make('conditions.weight')
                            ->label('Kapasitas Berat / Load Capacity (Form 2)')
                            ->multiple()
                            ->options(fn () => DSSCriteria::where('field_type', 'weight')->pluck('name', 'code'))
                            ->searchable()
                            ->required(),

                        Select::make('conditions.height')
                            ->label('Ketinggian Angkat / Lift Height (Form 2)')
                            ->multiple()
                            ->options(fn () => DSSCriteria::where('field_type', 'height')->pluck('name', 'code'))
                            ->searchable()
                            ->required(),
                    ]),
                ]),

            Section::make('Pengaturan Tambahan')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('priority')
                            ->label('Prioritas')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->inline(false),
                    ]),
                ]),
        ]);
    }
}
