<?php

namespace App\Filament\Resources\Faqs;

use App\Filament\Resources\Faqs\Pages\CreateFaq;
use App\Filament\Resources\Faqs\Pages\EditFaq;
use App\Filament\Resources\Faqs\Pages\ListFaqs;
use App\Filament\Resources\Faqs\Pages\ViewFaq;
use App\Filament\Resources\Faqs\Schemas\FaqForm;
use App\Filament\Resources\Faqs\Schemas\FaqInfolist;
use App\Filament\Resources\Faqs\Tables\FaqsTable;
use App\Models\Faq;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Traits\HasShieldAccess;

class FaqResource extends Resource
{
    use HasShieldAccess;
    protected static ?string $model = Faq::class;

    protected static UnitEnum|string|null $navigationGroup = 'Website Content';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationLabel = 'FAQs';

    public static function form(Schema $schema): Schema
    {
        return FaqForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FaqInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FaqsTable::configure($table);
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
            'index' => ListFaqs::route('/'),
            'create' => CreateFaq::route('/create'),
            'view' => ViewFaq::route('/{record}'),
            'edit' => EditFaq::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
