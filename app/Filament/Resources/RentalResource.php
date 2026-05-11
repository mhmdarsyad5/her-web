<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentalResource\Pages;
use App\Models\Customer;
use App\Models\Equipment;
use App\Models\Rental;
use BackedEnum;
use UnitEnum;
use Carbon\Carbon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Response;

class RentalResource extends Resource
{
    protected static ?string $model = Rental::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Data Penyewaan';
    protected static ?string $modelLabel = 'Penyewaan';
    protected static ?string $pluralModelLabel = 'Data Penyewaan';
    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Penyewaan';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }



    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Rental')
                ->tabs([

                    Tab::make('Detail Penyewaan')
                        ->icon('heroicon-o-clipboard-document')
                        ->schema([
                            TextInput::make('rental_code')
                                ->label('Kode Rental')
                                ->placeholder('Dibuat otomatis')
                                ->disabled()
                                ->dehydrated(false),

                            Select::make('equipment_id')
                                ->label('Alat')
                                ->relationship('equipment', 'name')
                                ->getOptionLabelFromRecordUsing(fn ($record) => "[{$record->code}] {$record->name}")
                                ->searchable()
                                ->required()
                                ->live()
                                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                    if ($state) {
                                        $equipment = Equipment::find($state);
                                        if ($equipment) {
                                            $set('rate_amount', $equipment->monthly_rate ?? 0);
                                            $set('deposit', $equipment->deposit ?? 0);
                                            self::recalculateTotal($set, $get);
                                        }
                                    }
                                }),

                            Select::make('customer_id')
                                ->label('Pelanggan')
                                ->options(
                                    fn() => Customer::where('is_active', true)
                                        ->get()
                                        ->mapWithKeys(fn($c) => [$c->id => $c->display_name])
                                )
                                ->searchable()
                                ->required()
                                ->createOptionForm([
                                    TextInput::make('name')->label('Nama')->required(),
                                    TextInput::make('phone')->label('No. HP/WA')->required(),
                                    Select::make('customer_type')
                                        ->label('Tipe')
                                        ->options(['individual' => 'Perorangan', 'company' => 'Perusahaan'])
                                        ->default('individual'),
                                ])
                                ->createOptionUsing(fn(array $data) => Customer::create($data)->id),

                            DatePicker::make('rental_start')
                                ->label('Tanggal Mulai')
                                ->required()
                                ->default(now())
                                ->live()
                                ->afterStateUpdated(
                                    fn($state, Set $set, Get $get) =>
                                    self::recalculateTotal($set, $get)
                                ),

                            DatePicker::make('rental_end')
                                ->label('Estimasi Kembali')
                                ->required()
                                ->live()
                                ->afterStateUpdated(
                                    fn($state, Set $set, Get $get) =>
                                    self::recalculateTotal($set, $get)
                                ),

                            Textarea::make('notes')
                                ->label('Catatan')
                                ->rows(3)
                                ->columnSpanFull(),
                        ])
                        ->columns(2),

                    Tab::make('Biaya')
                        ->icon('heroicon-o-calculator')
                        ->schema([
                            TextInput::make('rate_amount')
                                ->label('Harga Per Bulan (Rp)')
                                ->numeric()
                                ->prefix('Rp')
                                ->required()
                                ->disabled()
                                ->dehydrated(true),

                            TextInput::make('deposit')
                                ->label('Uang Jaminan (Rp)')
                                ->numeric()
                                ->prefix('Rp')
                                ->default(0),

                            TextInput::make('duration_days')
                                ->label('Durasi (Hari)')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(true),

                            TextInput::make('total_cost')
                                ->label('Total Biaya (Rp)')
                                ->prefix('Rp')
                                ->disabled()
                                ->dehydrated(true),
                        ])
                        ->columns(2),

                    Tab::make('Pengembalian')
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->schema([
                            DatePicker::make('actual_return')
                                ->label('Tanggal Kembali Aktual')
                                ->helperText('Isi saat alat sudah dikembalikan'),

                            Select::make('return_condition')
                                ->label('Kondisi Saat Kembali')
                                ->options([
                                    'excellent' => '⭐ Sangat Baik',
                                    'good' => '✅ Baik',
                                    'damaged' => '🔴 Ada Kerusakan (→ Maintenance)',
                                ]),

                            Textarea::make('return_notes')
                                ->label('Catatan Pengembalian')
                                ->rows(3)
                                ->columnSpanFull(),
                        ])
                        ->columns(2),

                ])
                ->columnSpanFull(),
        ]);
    }

    protected static function recalculateTotal(Set $set, Get $get): void
    {
        $start = $get('rental_start');
        $end = $get('rental_end');
        $rateAmt = (float) ($get('rate_amount') ?? 0);

        if ($start && $end) {
            $days = (int) Carbon::parse($start)->diffInDays(Carbon::parse($end)) + 1;
            $set('duration_days', $days);

            $total = ceil($days / 30) * $rateAmt;

            $set('total_cost', $total);
        }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rental_code')
                    ->label('Kode')
                    ->searchable()
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('equipment.name')
                    ->label('Alat')
                    ->searchable()
                    ->description(fn($record) => $record->equipment?->code ?? '—'),

                TextColumn::make('customer.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->description(fn($record) => $record->customer?->phone ?? '—'),

                TextColumn::make('rental_start')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('rental_end')
                    ->label('Est. Kembali')
                    ->date('d M Y')
                    ->sortable()
                    ->color(fn($record) => $record->isOverdue() ? 'danger' : null),

                TextColumn::make('duration_days')
                    ->label('Hari')
                    ->suffix(' hari')
                    ->alignCenter(),

                TextColumn::make('total_cost')
                    ->label('Total')
                    ->money('IDR'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'pending' => 'warning',
                        'active' => 'success',
                        'returned' => 'gray',
                        'overdue' => 'danger',
                        'cancelled' => 'secondary',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'pending' => 'Menunggu',
                        'active' => 'Aktif',
                        'returned' => 'Dikembalikan',
                        'overdue' => 'Terlambat',
                        'cancelled' => 'Dibatalkan',
                        default => $state,
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu',
                        'active' => 'Aktif',
                        'returned' => 'Dikembalikan',
                        'overdue' => 'Terlambat',
                        'cancelled' => 'Dibatalkan',
                    ]),

                Filter::make('overdue')
                    ->label('Terlambat Saja')
                    ->query(fn(Builder $query) => $query->where('status', 'overdue')),

                Filter::make('rental_date')
                    ->label('Rentang Tanggal')
                    ->form([
                        DatePicker::make('from')->label('Dari'),
                        DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('rental_start', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('rental_start', '<=', $data['until']));
                    }),
            ])
            ->actions([
                Action::make('activate')
                    ->label('Aktifkan')
                    ->icon('heroicon-o-play')
                    ->color('success')
                    ->visible(fn($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Aktifkan Penyewaan?')
                    ->modalDescription('Alat akan ditandai Sedang Disewa.')
                    ->action(function ($record) {
                        $record->update(['status' => 'active']);
                        Notification::make()
                            ->title('Rental Diaktifkan')
                            ->body("Rental {$record->rental_code} sekarang Aktif.")
                            ->success()->send();
                    }),

                Action::make('return')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('warning')
                    ->visible(fn($record) => in_array($record->status, ['active', 'overdue']))
                    ->form([
                        DatePicker::make('actual_return')
                            ->label('Tanggal Kembali')
                            ->required()
                            ->default(now()),
                        Select::make('return_condition')
                            ->label('Kondisi Alat Saat Kembali')
                            ->options([
                                'excellent' => '⭐ Sangat Baik',
                                'good' => '✅ Baik',
                                'damaged' => '🔴 Ada Kerusakan (→ Maintenance)',
                            ])
                            ->required(),
                        Textarea::make('return_notes')
                            ->label('Catatan Pengembalian')
                            ->rows(3),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => 'returned',
                            'actual_return' => $data['actual_return'],
                            'return_condition' => $data['return_condition'],
                            'return_notes' => $data['return_notes'] ?? null,
                        ]);
                        Notification::make()
                            ->title('Alat Sudah Dikembalikan')
                            ->body($data['return_condition'] === 'damaged'
                                ? 'Alat masuk status Maintenance.'
                                : 'Alat kembali ke status Tersedia.')
                            ->success()->send();
                    }),

                Action::make('cancel')
                    ->label('Batalkan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan Penyewaan?')
                    ->action(function ($record) {
                        $record->update(['status' => 'cancelled']);
                        Notification::make()
                            ->title('Rental Dibatalkan')
                            ->warning()->send();
                    }),

                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('exportCsv')
                        ->label('Export CSV')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(function (\Illuminate\Support\Collection $records) {
                            $csvData = $records->map(fn($r) => [
                                $r->rental_code,
                                $r->equipment?->name ?? '—',
                                $r->customer?->name ?? '—',
                                $r->customer?->phone ?? '—',
                                $r->rental_start?->format('d M Y') ?? '—',
                                $r->rental_end?->format('d M Y') ?? '—',
                                $r->duration_days,
                                'Rp ' . number_format($r->total_cost, 0, ',', '.'),
                                'Rp ' . number_format($r->deposit ?? 0, 0, ',', '.'),
                                $r->status_label,
                                $r->actual_return?->format('d M Y') ?? '—',
                                $r->return_condition ?? '—',
                                $r->return_notes ?? '',
                                $r->notes ?? '',
                                $r->operator?->name ?? '—',
                            ]);

                            $headers = ['Kode', 'Alat', 'Pelanggan', 'HP', 'Mulai', 'Estimasi Kembali', 'Durasi', 'Total', 'Deposit', 'Status', 'Tgl Kembali', 'Kondisi', 'Catatan Kembali', 'Catatan', 'Operator'];

                            $callback = function () use ($csvData, $headers) {
                                $handle = fopen('php://output', 'w');
                                fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM for Excel UTF-8
                                fputcsv($handle, $headers);
                                foreach ($csvData as $row) {
                                    fputcsv($handle, $row);
                                }
                                fclose($handle);
                            };

                            return Response::streamDownload($callback, 'penyewaan-' . now()->format('Y-m-d') . '.csv', [
                                'Content-Type' => 'text/csv',
                                'Content-Disposition' => 'attachment; filename="penyewaan-' . now()->format('Y-m-d') . '.csv"',
                            ]);
                        })
                        ->deselectRecordsAfterCompletion(),
                ])
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRentals::route('/'),
            'create' => Pages\CreateRental::route('/create'),
            'edit' => Pages\EditRental::route('/{record}/edit'),
        ];
    }
}
