<?php

namespace App\Filament\Resources\Pages\PageTags;

use App\Filament\Resources\Pages\PageTags\Pages\ManagePageTags;
use App\Models\PageTag;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageTagResource extends Resource
{
    protected static ?string $model = PageTag::class;

    protected static ?string $slug = 'tag-artikel';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationIcon(): string|\Filament\Support\Icons\Heroicon|\BackedEnum|null
    {
        return \Filament\Support\Icons\Heroicon::OutlinedTag;
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Website Content';
    }

    public static function getNavigationSort(): ?int
    {
        return 8;
    }

    public static function getModelLabel(): string
    {
        return 'Tag Artikel';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Tag Artikel';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Tag')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(PageTag::class, 'slug', ignoreRecord: true),

                Section::make('SEO Metadata (Opsional)')
                    ->description('Atur optimasi mesin pencari secara manual. Jika dikosongkan, sistem akan men-generate SEO otomatis secara pintar.')
                    ->collapsible()
                    ->schema([
                        TextInput::make('seo_title')
                            ->label('SEO Title')
                            ->placeholder('Contoh: Kumpulan artikel tentang Sewa Forklift Murah')
                            ->maxLength(255)
                            ->helperText('Jika dikosongkan, akan terisi otomatis: "Kumpulan Artikel [Nama Tag] - [Nama Website]"'),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->placeholder('Tulis deskripsi ringkas halaman tag ini...')
                            ->rows(3)
                            ->maxLength(255)
                            ->helperText('Jika dikosongkan, akan terisi otomatis berdasarkan nama tag.'),

                        TextInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->placeholder('Contoh: sewa forklift, forklift jakarta, forklift murah')
                            ->maxLength(255)
                            ->helperText('Pisahkan kata kunci dengan koma. Jika kosong, terisi otomatis dari nama tag.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Tag')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('pages_count')
                    ->counts('pages')
                    ->label('Jml Artikel'),
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
            'index' => ManagePageTags::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
