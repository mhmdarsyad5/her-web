<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DSSCriteria\Schemas\DSSCriteriaForm;
use App\Filament\Resources\DSSCriteria\Tables\DSSCriteriaTable;
use App\Filament\Resources\DSSCriteriaResource\Pages;
use App\Models\DSSCriteria;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class DSSCriteriaResource extends Resource
{
    protected static ?string $model = DSSCriteria::class;

    protected static ?string $label = 'Industri';

    protected static ?string $pluralLabel = 'Industri';

    protected static UnitEnum|string|null $navigationGroup = 'Website Content';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office';

    public static function form(Schema $schema): Schema
    {
        return DSSCriteriaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DSSCriteriaTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDSSCriteria::route('/'),
            'create' => Pages\CreateDSSCriteria::route('/create'),
            'edit' => Pages\EditDSSCriteria::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
