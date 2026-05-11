<?php

namespace App\Filament\Resources\DSSRule\Schemas;

use App\Models\DSSCriteria;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DSSRuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Produk')
                ->description('Detail produk yang akan ditampilkan jika kriteria cocok.')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('product_name')
                            ->label('Nama Produk')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('category_name')
                            ->label('Kategori')
                            ->required()
                            ->maxLength(255),
                    ]),
                    Grid::make(3)->schema([
                        TextInput::make('brand')
                            ->label('Brand')
                            ->placeholder('HANGCHA'),
                        TextInput::make('model')
                            ->label('Model / Tipe'),
                        TextInput::make('name')
                            ->label('Deskripsi Singkat Rule')
                            ->placeholder('e.g. Lithium Indoor Forklift'),
                    ]),
                ]),

            Section::make('Kriteria Pencocokan (Logika Yes/No)')
                ->description('Pilih kriteria yang harus dipenuhi agar produk ini muncul.')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('conditions.location')
                            ->label('Lokasi Operasional')
                            ->multiple()
                            ->options(fn() => DSSCriteria::where('field_type', 'location')->pluck('name', 'code'))
                            ->searchable(),
                        
                        Select::make('conditions.weight')
                            ->label('Kapasitas Berat')
                            ->multiple()
                            ->options(fn() => DSSCriteria::where('field_type', 'weight')->pluck('name', 'code'))
                            ->searchable(),
                        
                        Select::make('conditions.height')
                            ->label('Ketinggian Angkat')
                            ->multiple()
                            ->options(fn() => DSSCriteria::where('field_type', 'height')->pluck('name', 'code'))
                            ->searchable(),

                        Select::make('conditions.aisle')
                            ->label('Lebar Lorong (Aisle)')
                            ->multiple()
                            ->options(fn() => DSSCriteria::where('field_type', 'aisle')->pluck('name', 'code'))
                            ->searchable(),

                        Select::make('conditions.energy')
                            ->label('Sumber Energi')
                            ->options(fn() => DSSCriteria::where('field_type', 'energy')->pluck('name', 'code'))
                            ->searchable(),

                        Select::make('conditions.operator')
                            ->label('Jenis Operator')
                            ->options(fn() => DSSCriteria::where('field_type', 'operator')->pluck('name', 'code'))
                            ->searchable(),
                        
                        Select::make('conditions.cargo_type')
                            ->label('Jenis Muatan')
                            ->multiple()
                            ->options(fn() => DSSCriteria::where('field_type', 'cargo_type')->pluck('name', 'code'))
                            ->searchable(),
                        
                        Select::make('conditions.industry')
                            ->label('Jenis Industri')
                            ->multiple()
                            ->options(fn() => DSSCriteria::where('field_type', 'industry')->pluck('name', 'code'))
                            ->searchable(),
                    ]),
                ]),

            Section::make('Pengaturan Tambahan')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('priority')
                            ->label('Prioritas')
                            ->numeric()
                            ->default(0),
                        TextInput::make('relevance_score')
                            ->label('Skor Relevansi')
                            ->numeric()
                            ->default(100),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->inline(false),
                    ]),
                ]),
        ]);
    }
}
