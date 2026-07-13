<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentCategoryResource\Pages;
use App\Models\EquipmentCategory;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Illuminate\Support\Str;

class EquipmentCategoryResource extends Resource
{
    protected static ?string $model = EquipmentCategory::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Kategori Alat';
    protected static ?string $modelLabel = 'Kategori Alat';
    protected static ?string $pluralModelLabel = 'Kategori Alat';
    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Alat';
    protected static ?int $navigationSort = 1;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Kategori')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Kategori')
                        ->required()
                        ->maxLength(100),

                    Textarea::make('description')
                        ->label('Deskripsi')
                        ->rows(3)
                        ->columnSpanFull(),

                    Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),

                    TextInput::make('sort_order')
                        ->label('Urutan')
                        ->numeric()
                        ->default(0),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable()
                    ->width(50),

                TextColumn::make('name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),



                TextColumn::make('equipment_count')
                    ->label('Jumlah Alat')
                    ->getStateUsing(fn($record) => $record->equipment()->count())
                    ->badge()
                    ->color('info'),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label('Status Aktif'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                    \Filament\Actions\BulkAction::make('exportCsv')
                        ->label('Export CSV')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(function (\Illuminate\Support\Collection $records) {
                            $csvData = $records->map(fn($r) => [
                                $r->name,
                                $r->description ?? '—',
                                $r->equipment()->count(),
                                $r->is_active ? 'Aktif' : 'Non-Aktif',
                                $r->sort_order,
                            ]);

                            $headers = ['Nama Kategori', 'Deskripsi', 'Jumlah Alat', 'Status', 'Urutan'];

                            $callback = function () use ($csvData, $headers) {
                                $handle = fopen('php://output', 'w');
                                fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
                                fputcsv($handle, $headers);
                                foreach ($csvData as $row) {
                                    fputcsv($handle, $row);
                                }
                                fclose($handle);
                            };

                            return \Illuminate\Support\Facades\Response::streamDownload($callback, 'kategori-alat-' . now()->format('Y-m-d') . '.csv', [
                                'Content-Type' => 'text/csv',
                            ]);
                        })
                        ->deselectRecordsAfterCompletion(),
                ])
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipmentCategories::route('/'),
            'create' => Pages\CreateEquipmentCategory::route('/create'),
            'edit' => Pages\EditEquipmentCategory::route('/{record}/edit'),
        ];
    }
}
