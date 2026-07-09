<?php

namespace App\Filament\Resources\Pages\PageCategories;

use App\Filament\Resources\Pages\PageCategories\Pages\ManagePageCategories;
use App\Models\PageCategory;
use Illuminate\Support\Str;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PageCategoryResource extends Resource
{
    protected static ?string $model = PageCategory::class;
    protected static ?string $slug = 'kategori-artikel';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationIcon(): string|\Filament\Support\Icons\Heroicon|\BackedEnum|null
    {
        return \Filament\Support\Icons\Heroicon::OutlinedRectangleStack;
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Website Content';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function getModelLabel(): string
    {
        return 'Kategori Artikel';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Kategori Artikel';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(PageCategory::class, 'slug', ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Kategori')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('pages_count')
                    ->counts('pages')
                    ->label('Jumlah Artikel'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePageCategories::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
