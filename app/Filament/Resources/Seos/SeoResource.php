<?php

namespace App\Filament\Resources\Seos;

use App\Filament\Resources\Seos\Pages\CreateSeo;
use App\Filament\Resources\Seos\Pages\EditSeo;
use App\Filament\Resources\Seos\Pages\ListSeos;
use App\Filament\Resources\Seos\Schemas\SeoForm;
use App\Filament\Resources\Seos\Tables\SeosTable;
use App\Models\Seo;
use App\Traits\HasShieldAccess;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SeoResource extends Resource
{
    use HasShieldAccess;

    protected static ?string $model = Seo::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static UnitEnum|string|null $navigationGroup = 'Website Content';

    protected static ?string $navigationLabel = 'SEO Website';

    protected static ?int $navigationSort = 11;

    public static function form(Schema $schema): Schema
    {
        return SeoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SeosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSeos::route('/'),
            'create' => CreateSeo::route('/create'),
            'edit' => EditSeo::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
