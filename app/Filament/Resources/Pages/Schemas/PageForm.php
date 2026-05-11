<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([

                /* =====================
                 * PAGE TITLE & CONTENT
                 * ===================== */
                TextInput::make('title')
                    ->label('Judul Halaman')
                    ->required()
                    ->maxLength(200)
                    ->placeholder('Contoh: Tentang Kami')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    })
                    ->columnSpanFull(),

                RichEditor::make('content')
                    ->label('Konten Halaman')
                    ->placeholder('Tulis isi halaman...')
                    ->columnSpanFull(),

                /* =====================
                 * SLUG
                 * ===================== */
                TextInput::make('slug')
                    ->label('Slug URL')
                    ->required()
                    ->placeholder('Akan terisi otomatis dari Judul')
                    ->columnSpan(1),

                /* =====================
                 * KATEGORI & TAG
                 * ===================== */
                Group::make([
                    Select::make('category_id')
                        ->label('Kategori')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                            TextInput::make('slug')
                                ->required()
                                ->maxLength(255)
                                ->unique('page_categories', 'slug')
                        ]),

                    Select::make('tags')
                        ->label('Tags / Label')
                        ->relationship('tags', 'name')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                            TextInput::make('slug')
                                ->required()
                                ->maxLength(255)
                                ->unique('page_tags', 'slug')
                        ]),
                ])->columnSpanFull()->columns(2),

                /* =====================
                 * THUMBNAIL
                 * ===================== */
                FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->directory('pages')
                    ->disk('public')
                    ->image()
                    ->imageEditor()
                    ->helperText('Thumbnail halaman (opsional).')
                    ->columnSpan(1),

                /* =====================
                 * PUBLISH SETTINGS
                 * ===================== */
                Toggle::make('is_published')
                    ->label('Publish?')
                    ->default(false)
                    ->helperText('Aktifkan agar halaman tampil di website.')
                    ->columnSpan(1),

                DateTimePicker::make('publish_at')
                    ->label('Publish At')
                    ->visible(fn(callable $get) => $get('is_published'))
                    ->helperText('Kosongkan jika ingin publish sekarang.')
                    ->columnSpan(1),
            ]);
    }
}
