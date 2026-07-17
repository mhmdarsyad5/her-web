<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentMaintenanceResource\Pages;
use App\Models\Equipment;
use App\Models\EquipmentMaintenance;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class EquipmentMaintenanceResource extends Resource
{
    protected static ?string $model = EquipmentMaintenance::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench';

    protected static ?string $navigationLabel = 'Maintenance Alat';

    protected static ?string $modelLabel = 'Maintenance Alat';

    protected static ?string $pluralModelLabel = 'Maintenance Alat';

    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Alat';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detail Maintenance')
                ->schema([
                    Select::make('equipment_id')
                        ->label('Alat')
                        ->options(
                            fn () => Equipment::active()
                                ->get()
                                ->mapWithKeys(fn ($e) => [$e->id => "[{$e->code}] {$e->name} — {$e->status_label}"])
                        )
                        ->searchable()
                        ->required(),

                    Select::make('performed_by')
                        ->label('Dikerjakan Oleh')
                        ->options(User::pluck('name', 'id'))
                        ->searchable()
                        ->nullable(),

                    Select::make('maintenance_type')
                        ->label('Jenis Maintenance')
                        ->options([
                            'routine' => '🔄 Rutin',
                            'repair' => '🔧 Perbaikan',
                            'inspection' => '🔍 Inspeksi',
                        ])
                        ->default('routine')
                        ->required(),

                    TextInput::make('title')
                        ->label('Judul Pekerjaan')
                        ->required()
                        ->maxLength(200)
                        ->placeholder('Ganti oli mesin, cek hidrolik, dll.'),

                    DatePicker::make('start_date')
                        ->label('Tanggal Mulai')
                        ->required()
                        ->default(now()),

                    DatePicker::make('end_date')
                        ->label('Tanggal Selesai')
                        ->nullable(),

                    DatePicker::make('next_maintenance_date')
                        ->label('Jadwal Maintenance Berikutnya')
                        ->nullable(),

                    TextInput::make('cost')
                        ->label('Biaya (Rp)')
                        ->numeric()
                        ->prefix('Rp')
                        ->default(0),

                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'scheduled' => '📅 Terjadwal',
                            'in_progress' => '🔧 Sedang Dikerjakan',
                            'completed' => '✅ Selesai',
                        ])
                        ->default('scheduled')
                        ->required()
                        ->live(),

                    Textarea::make('description')
                        ->label('Deskripsi Pekerjaan')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('notes')
                        ->label('Catatan')
                        ->rows(2)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('equipment.name')
                    ->label('Alat')
                    ->searchable()
                    ->description(fn ($record) => $record->equipment?->code ?? '—'),

                TextColumn::make('maintenance_type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'routine' => 'info',
                        'repair' => 'danger',
                        'inspection' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'routine' => 'Rutin',
                        'repair' => 'Perbaikan',
                        'inspection' => 'Inspeksi',
                        default => $state,
                    }),

                TextColumn::make('title')
                    ->label('Pekerjaan')
                    ->searchable(),

                TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Selesai')
                    ->date('d M Y')
                    ->placeholder('—'),

                TextColumn::make('cost')
                    ->label('Biaya')
                    ->money('IDR'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'scheduled' => 'gray',
                        'in_progress' => 'warning',
                        'completed' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'scheduled' => 'Terjadwal',
                        'in_progress' => 'Dikerjakan',
                        'completed' => 'Selesai',
                        default => $state,
                    }),
            ])
            ->filters([
                SelectFilter::make('maintenance_type')
                    ->label('Jenis')
                    ->options([
                        'routine' => 'Rutin',
                        'repair' => 'Perbaikan',
                        'inspection' => 'Inspeksi',
                    ]),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'scheduled' => 'Terjadwal',
                        'in_progress' => 'Dikerjakan',
                        'completed' => 'Selesai',
                    ]),
            ])
            ->actions([
                Action::make('start')
                    ->label('Mulai')
                    ->icon('heroicon-o-play')
                    ->color('warning')
                    ->visible(fn ($record) => $record->status === 'scheduled')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['status' => 'in_progress']);
                        Notification::make()
                            ->title('Maintenance dimulai')
                            ->body('Status alat diubah ke Maintenance.')
                            ->warning()->send();
                    }),

                Action::make('complete')
                    ->label('Selesaikan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'in_progress')
                    ->form([
                        DatePicker::make('end_date')
                            ->label('Tanggal Selesai')
                            ->required()
                            ->default(now()),
                        DatePicker::make('next_maintenance_date')
                            ->label('Jadwal Berikutnya'),
                        Textarea::make('notes')
                            ->label('Catatan Penyelesaian')
                            ->rows(3),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => 'completed',
                            'end_date' => $data['end_date'],
                            'next_maintenance_date' => $data['next_maintenance_date'] ?? null,
                            'notes' => $data['notes'] ?? $record->notes,
                        ]);
                        Notification::make()
                            ->title('Maintenance Selesai')
                            ->body('Alat kembali ke status Tersedia.')
                            ->success()->send();
                    }),

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
                            $csvData = $records->map(fn ($r) => [
                                $r->equipment?->code ?? '—',
                                $r->equipment?->name ?? '—',
                                match ($r->maintenance_type) {
                                    'routine' => 'Rutin',
                                    'repair' => 'Perbaikan',
                                    'inspection' => 'Inspeksi',
                                    default => $r->maintenance_type,
                                },
                                $r->title,
                                $r->start_date?->format('d M Y') ?? '—',
                                $r->end_date?->format('d M Y') ?? '—',
                                $r->cost,
                                match ($r->status) {
                                    'scheduled' => 'Terjadwal',
                                    'in_progress' => 'Dikerjakan',
                                    'completed' => 'Selesai',
                                    default => $r->status,
                                },
                                $r->performedBy?->name ?? '—',
                                $r->description ?? '',
                                $r->notes ?? '',
                            ]);

                            $headers = ['Kode Alat', 'Nama Alat', 'Jenis', 'Pekerjaan', 'Mulai', 'Selesai', 'Biaya', 'Status', 'Oleh', 'Deskripsi', 'Catatan'];

                            $callback = function () use ($csvData, $headers) {
                                $handle = fopen('php://output', 'w');
                                fwrite($handle, chr(0xEF).chr(0xBB).chr(0xBF));
                                fputcsv($handle, $headers);
                                foreach ($csvData as $row) {
                                    fputcsv($handle, $row);
                                }
                                fclose($handle);
                            };

                            return \Illuminate\Support\Facades\Response::streamDownload($callback, 'maintenance-alat-'.now()->format('Y-m-d').'.csv', [
                                'Content-Type' => 'text/csv',
                            ]);
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('start_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipmentMaintenances::route('/'),
            'create' => Pages\CreateEquipmentMaintenance::route('/create'),
            'edit' => Pages\EditEquipmentMaintenance::route('/{record}/edit'),
        ];
    }
}
