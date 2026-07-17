<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentResource\Pages;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section as InfoSection;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Data Alat';

    protected static ?string $modelLabel = 'Data Alat';

    protected static ?string $pluralModelLabel = 'Data Alat';

    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Alat';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Tabs')
                ->tabs([

                    Tab::make('Informasi Dasar')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Select::make('category_id')
                                ->label('Kategori')
                                ->options(EquipmentCategory::where('is_active', true)->pluck('name', 'id'))
                                ->searchable()
                                ->required(),

                            TextInput::make('code')
                                ->label('Kode Alat')
                                ->placeholder('ALT-001')
                                ->helperText('Akan dibuat otomatis jika dikosongkan')
                                ->unique(ignoreRecord: true)
                                ->maxLength(30),

                            TextInput::make('name')
                                ->label('Nama Alat')
                                ->required()
                                ->maxLength(200),

                            TextInput::make('brand')
                                ->label('Merek')
                                ->maxLength(100),

                            TextInput::make('model')
                                ->label('Model / Seri')
                                ->maxLength(100),

                            TextInput::make('year')
                                ->label('Tahun Pembuatan')
                                ->numeric()
                                ->minValue(1950)
                                ->maxValue(now()->year + 1),

                            Select::make('condition')
                                ->label('Kondisi')
                                ->options([
                                    'excellent' => '⭐ Sangat Baik',
                                    'good' => '✅ Baik',
                                    'fair' => '⚠️ Cukup',
                                    'poor' => '🔴 Perlu Perbaikan',
                                ])
                                ->default('good')
                                ->required(),

                            TextInput::make('location')
                                ->label('Lokasi / Gudang')
                                ->maxLength(200),

                            Textarea::make('description')
                                ->label('Deskripsi')
                                ->rows(4)
                                ->columnSpanFull(),

                            Textarea::make('notes')
                                ->label('Catatan Internal')
                                ->rows(3)
                                ->columnSpanFull(),
                        ])
                        ->columns(2),

                    Tab::make('Harga Sewa')
                        ->icon('heroicon-o-currency-dollar')
                        ->schema([
                            TextInput::make('monthly_rate')
                                ->label('Harga Per Bulan (Rp)')
                                ->numeric()
                                ->prefix('Rp')
                                ->placeholder('50000000'),

                            TextInput::make('deposit')
                                ->label('Uang Jaminan (Rp)')
                                ->numeric()
                                ->prefix('Rp')
                                ->placeholder('1000000'),
                        ])
                        ->columns(2),

                    Tab::make('Spesifikasi Teknis')
                        ->icon('heroicon-o-list-bullet')
                        ->schema([
                            Repeater::make('specifications')
                                ->label('Spesifikasi')
                                ->schema([
                                    TextInput::make('key')
                                        ->label('Nama Spesifikasi')
                                        ->placeholder('Kapasitas Angkat')
                                        ->required(),
                                    TextInput::make('value')
                                        ->label('Nilai')
                                        ->placeholder('10 ton')
                                        ->required(),
                                ])
                                ->columns(2)
                                ->addActionLabel('+ Tambah Spesifikasi')
                                ->defaultItems(0)
                                ->columnSpanFull(),
                        ]),

                    Tab::make('Foto')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make('images')
                                ->label('Foto Alat')
                                ->image()
                                ->multiple()
                                ->reorderable()
                                ->maxFiles(10)
                                ->disk('public')
                                ->directory('equipment')
                                ->columnSpanFull(),
                        ]),

                    Tab::make('Status')
                        ->icon('heroicon-o-signal')
                        ->schema([
                            Select::make('status')
                                ->label('Status Alat')
                                ->options([
                                    'available' => '✅ Tersedia',
                                    'rented' => '🔵 Sedang Disewa',
                                    'maintenance' => '🔧 Maintenance',
                                    'retired' => '⚫ Tidak Aktif',
                                ])
                                ->default('available')
                                ->required(),

                            TextInput::make('sort_order')
                                ->label('Urutan Tampil')
                                ->numeric()
                                ->default(0),
                        ])
                        ->columns(2),

                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->weight('bold')
                    ->width(90),

                TextColumn::make('name')
                    ->label('Nama Alat')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => trim(($record->brand ?? '').($record->model ? ' — '.$record->model : ''))),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'available' => 'success',
                        'rented' => 'primary',
                        'maintenance' => 'warning',
                        'retired' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'available' => 'Tersedia',
                        'rented' => 'Disewa',
                        'maintenance' => 'Maintenance',
                        'retired' => 'Tidak Aktif',
                        default => $state,
                    }),

                TextColumn::make('condition')
                    ->label('Kondisi')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'excellent', 'good' => 'success',
                        'fair' => 'warning',
                        'poor' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'excellent' => 'Sangat Baik',
                        'good' => 'Baik',
                        'fair' => 'Cukup',
                        'poor' => 'Perlu Perbaikan',
                        default => $state,
                    }),

                TextColumn::make('monthly_rate')
                    ->label('Harga/Bulan')
                    ->money('IDR')
                    ->placeholder('—'),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->placeholder('—')
                    ->toggleable(),

            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->options(EquipmentCategory::pluck('name', 'id')),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'available' => 'Tersedia',
                        'rented' => 'Sedang Disewa',
                        'maintenance' => 'Maintenance',
                        'retired' => 'Tidak Aktif',
                    ]),

            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    \Filament\Actions\BulkAction::make('exportCsv')
                        ->label('Export CSV')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(function (\Illuminate\Support\Collection $records) {
                            $csvData = $records->map(fn ($r) => [
                                $r->code,
                                $r->name,
                                $r->category?->name ?? '—',
                                $r->brand ?? '—',
                                $r->model ?? '—',
                                $r->year ?? '—',
                                $r->location ?? '—',
                                match ($r->status) {
                                    'available' => 'Tersedia',
                                    'rented' => 'Sedang Disewa',
                                    'maintenance' => 'Maintenance',
                                    'retired' => 'Tidak Aktif',
                                    default => $r->status,
                                },
                                match ($r->condition) {
                                    'excellent' => 'Sangat Baik',
                                    'good' => 'Baik',
                                    'fair' => 'Cukup',
                                    'poor' => 'Perlu Perbaikan',
                                    default => $r->condition,
                                },
                                $r->monthly_rate,
                                $r->deposit,
                            ]);

                            $headers = ['Kode', 'Nama', 'Kategori', 'Merek', 'Model', 'Tahun', 'Lokasi', 'Status', 'Kondisi', 'Harga Sewa/Bulan', 'Jaminan'];

                            $callback = function () use ($csvData, $headers) {
                                $handle = fopen('php://output', 'w');
                                fwrite($handle, chr(0xEF).chr(0xBB).chr(0xBF));
                                fputcsv($handle, $headers);
                                foreach ($csvData as $row) {
                                    fputcsv($handle, $row);
                                }
                                fclose($handle);
                            };

                            return \Illuminate\Support\Facades\Response::streamDownload($callback, 'data-alat-'.now()->format('Y-m-d').'.csv', [
                                'Content-Type' => 'text/csv',
                            ]);
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([

            // ─── Baris atas: Info + Gambar ───────────────────────────────
            InfoSection::make('Informasi Alat')
                ->schema([
                    TextEntry::make('code')
                        ->label('Kode Alat')
                        ->badge()
                        ->color('gray'),

                    TextEntry::make('name')
                        ->label('Nama Alat')
                        ->weight('bold'),

                    TextEntry::make('category.name')
                        ->label('Kategori')
                        ->badge()
                        ->color('primary'),

                    TextEntry::make('status')
                        ->label('Status')
                        ->badge()
                        ->color(fn ($state) => match ($state) {
                            'available' => 'success',
                            'rented' => 'primary',
                            'maintenance' => 'warning',
                            'retired' => 'danger',
                            default => 'gray',
                        })
                        ->formatStateUsing(fn ($state) => match ($state) {
                            'available' => '✅ Tersedia',
                            'rented' => '🔵 Sedang Disewa',
                            'maintenance' => '🔧 Maintenance',
                            'retired' => '⚫ Tidak Aktif',
                            default => $state,
                        }),

                    TextEntry::make('condition')
                        ->label('Kondisi')
                        ->badge()
                        ->color(fn ($state) => match ($state) {
                            'excellent', 'good' => 'success',
                            'fair' => 'warning',
                            'poor' => 'danger',
                            default => 'gray',
                        })
                        ->formatStateUsing(fn ($state) => match ($state) {
                            'excellent' => '⭐ Sangat Baik',
                            'good' => '✅ Baik',
                            'fair' => '⚠️ Cukup',
                            'poor' => '🔴 Perlu Perbaikan',
                            default => $state,
                        }),

                    TextEntry::make('brand')
                        ->label('Merek')
                        ->placeholder('—'),

                    TextEntry::make('model')
                        ->label('Model / Seri')
                        ->placeholder('—'),

                    TextEntry::make('year')
                        ->label('Tahun')
                        ->placeholder('—'),

                    TextEntry::make('location')
                        ->label('Lokasi / Gudang')
                        ->placeholder('—')
                        ->icon('heroicon-o-map-pin'),

                ])
                ->columns(3),

            // ─── Harga ────────────────────────────────────────────────────
            InfoSection::make('Harga Sewa')
                ->schema([
                    TextEntry::make('monthly_rate')
                        ->label('Per Bulan')
                        ->money('IDR')
                        ->placeholder('—')
                        ->icon('heroicon-o-calendar-days'),

                    TextEntry::make('deposit')
                        ->label('Uang Jaminan')
                        ->money('IDR')
                        ->placeholder('—')
                        ->icon('heroicon-o-shield-check'),
                ])
                ->columns(4)
                ->collapsible(),

            // ─── Foto Alat ────────────────────────────────────────────────
            InfoSection::make('Foto Alat')
                ->schema([
                    ImageEntry::make('images')
                        ->label('')
                        ->disk('public')
                        ->height(220)
                        ->extraImgAttributes(['class' => 'rounded-lg object-cover'])
                        ->columnSpanFull()
                        ->hidden(fn ($record) => empty($record->images)),

                    TextEntry::make('no_images')
                        ->label('')
                        ->getStateUsing(fn () => 'Belum ada foto yang diupload.')
                        ->columnSpanFull()
                        ->visible(fn ($record) => empty($record->images))
                        ->color('gray'),
                ])
                ->collapsible(),

            // ─── Spesifikasi Teknis ───────────────────────────────────────
            InfoSection::make('Spesifikasi Teknis')
                ->schema([
                    RepeatableEntry::make('specifications')
                        ->label('')
                        ->schema([
                            TextEntry::make('key')
                                ->label('Nama')
                                ->weight('bold'),
                            TextEntry::make('value')
                                ->label('Nilai'),
                        ])
                        ->columns(2)
                        ->columnSpanFull()
                        ->hidden(fn ($record) => empty($record->specifications)),

                    TextEntry::make('no_specs')
                        ->label('')
                        ->getStateUsing(fn () => 'Belum ada spesifikasi teknis.')
                        ->columnSpanFull()
                        ->visible(fn ($record) => empty($record->specifications))
                        ->color('gray'),
                ])
                ->collapsible(),

            // ─── Deskripsi & Catatan ─────────────────────────────────────
            InfoSection::make('Deskripsi & Catatan')
                ->schema([
                    TextEntry::make('description')
                        ->label('Deskripsi Umum')
                        ->placeholder('—')
                        ->columnSpanFull()
                        ->prose(),

                    TextEntry::make('notes')
                        ->label('Catatan Internal')
                        ->placeholder('—')
                        ->columnSpanFull(),
                ])
                ->collapsible(),

        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'edit' => Pages\EditEquipment::route('/{record}/edit'),
            'view' => Pages\ViewEquipment::route('/{record}'),
        ];
    }
}
