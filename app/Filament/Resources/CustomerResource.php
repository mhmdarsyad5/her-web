<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Response;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Data Pelanggan';
    protected static ?string $modelLabel = 'Pelanggan';
    protected static ?string $pluralModelLabel = 'Data Pelanggan';
    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Penyewaan';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Pelanggan')
                ->schema([
                    Select::make('customer_type')
                        ->label('Tipe Pelanggan')
                        ->options([
                            'individual' => '👤 Perorangan',
                            'company' => '🏢 Perusahaan',
                        ])
                        ->default('individual')
                        ->required()
                        ->live(),

                    TextInput::make('name')
                        ->label('Nama (PIC / Penanggung Jawab)')
                        ->required()
                        ->maxLength(150),

                    TextInput::make('company_name')
                        ->label('Nama Perusahaan')
                        ->maxLength(200)
                        ->visible(fn(Get $get) => $get('customer_type') === 'company'),

                    TextInput::make('phone')
                        ->label('No. HP / WA')
                        ->tel()
                        ->required()
                        ->maxLength(20),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->maxLength(150),

                    TextInput::make('id_number')
                        ->label('No. KTP / NPWP')
                        ->maxLength(50),

                    Textarea::make('address')
                        ->label('Alamat')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('notes')
                        ->label('Catatan')
                        ->rows(2)
                        ->columnSpanFull(),

                    Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->description(fn($record) => $record->company_name ?? null),

                TextColumn::make('customer_type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'individual' => 'info',
                        'company' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'individual' => 'Perorangan',
                        'company' => 'Perusahaan',
                        default => $state,
                    }),

                TextColumn::make('phone')
                    ->label('No. HP')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('rentals_count')
                    ->label('Total Rental')
                    ->counts('rentals')
                    ->badge()
                    ->color('gray'),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('customer_type')
                    ->label('Tipe')
                    ->options([
                        'individual' => 'Perorangan',
                        'company' => 'Perusahaan',
                    ]),
                TernaryFilter::make('is_active')->label('Status Aktif'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('exportCsv')
                        ->label('Export CSV')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(function (\Illuminate\Support\Collection $records) {
                            $csvData = $records->map(fn($r) => [
                                $r->name,
                                $r->company_name ?? '—',
                                match ($r->customer_type) {
                                    'individual' => 'Perorangan',
                                    'company' => 'Perusahaan',
                                    default => $r->customer_type,
                                },
                                $r->phone,
                                $r->email ?? '—',
                                $r->id_number ?? '—',
                                $r->address ?? '—',
                                $r->is_active ? 'Aktif' : 'Non-Aktif',
                                $r->created_at->format('d M Y'),
                            ]);

                            $headers = ['Nama', 'Perusahaan', 'Tipe', 'No. HP', 'Email', 'No. Identitas', 'Alamat', 'Status', 'Tgl Terdaftar'];

                            $callback = function () use ($csvData, $headers) {
                                $handle = fopen('php://output', 'w');
                                fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM for Excel UTF-8
                                fputcsv($handle, $headers);
                                foreach ($csvData as $row) {
                                    fputcsv($handle, $row);
                                }
                                fclose($handle);
                            };

                            return Response::streamDownload($callback, 'pelanggan-' . now()->format('Y-m-d') . '.csv', [
                                'Content-Type' => 'text/csv',
                                'Content-Disposition' => 'attachment; filename="pelanggan-' . now()->format('Y-m-d') . '.csv"',
                            ]);
                        })
                        ->deselectRecordsAfterCompletion(),
                ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
