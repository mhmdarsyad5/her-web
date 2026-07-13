<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DSSRule\Schemas\DSSRuleForm;
use App\Filament\Resources\DSSRule\Tables\DSSRulesTable;
use App\Filament\Resources\DSSRuleResource\Pages;
use App\Models\DSSRule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class DSSRuleResource extends Resource
{
    protected static ?string $model = DSSRule::class;

    protected static ?string $label = 'DSS Rule';

    protected static ?string $pluralLabel = 'DSS Rules';

    protected static UnitEnum|string|null $navigationGroup = 'System Settings';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-adjustments-horizontal';

    public static function form(Schema $schema): Schema
    {
        return DSSRuleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DSSRulesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDSSRules::route('/'),
            'create' => Pages\CreateDSSRule::route('/create'),
            'edit' => Pages\EditDSSRule::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
