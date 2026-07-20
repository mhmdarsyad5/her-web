<?php

namespace App\Filament\Resources\Pages\Schemas;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Grid::make(3)->schema([
                    // Main column (left)
                    Group::make([
                        TextInput::make('title')
                            ->label('Judul Halaman')
                            ->required()
                            ->maxLength(200)
                            ->placeholder('Contoh: Tentang Kami')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('slug', Str::slug($state));
                            }),

                        TinyEditor::make('content')
                            ->label('Konten Halaman')
                            ->placeholder('Tulis isi halaman...')
                            ->height(350)
                            ->minHeight(200)
                            ->maxHeight(1000)
                            ->resize(true),

                        Textarea::make('excerpt')
                            ->label('Ringkasan / Excerpt')
                            ->placeholder('Tulis deskripsi singkat halaman ini untuk tampilan kartu...')
                            ->rows(3)
                            ->maxLength(255)
                            ->helperText('Maksimal 255 karakter. Jika dikosongkan, deskripsi diambil otomatis dari konten.'),
                    ])->columnSpan(2),

                    // Sidebar column (right)
                    Group::make([
                        Section::make('Detail Post')
                            ->schema([
                                TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->placeholder('Akan terisi otomatis dari Judul'),

                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'published' => 'Published',
                                        'draft' => 'Draft',
                                        'pending' => 'Pending',
                                    ])
                                    ->default('draft')
                                    ->required(),

                                DateTimePicker::make('publish_at')
                                    ->label('Tanggal Publikasi')
                                    ->native(false)
                                    ->displayFormat('d M Y H:i')
                                    ->seconds(false)
                                    ->default(now())
                                    ->helperText('Tanggal artikel ini mulai dipublikasikan.'),

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
                                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                                        TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique('page_categories', 'slug'),
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
                                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                                        TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique('page_tags', 'slug'),
                                    ]),
                            ]),

                        Section::make('Gambar Post')
                            ->schema([
                                \App\Support\FilamentImagePicker::make(
                                    fieldName: 'thumbnail',
                                    label: 'Thumbnail',
                                    directory: 'pages',
                                    prefix: 'blog',
                                    helperText: 'Thumbnail halaman. Maks: 5MB.'
                                ),
                            ]),

                        Section::make('SEO Content')
                            ->schema([
                                TextInput::make('seo_title')
                                    ->label('SEO Title')
                                    ->placeholder('Judul khusus SEO...')
                                    ->maxLength(100),

                                Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->placeholder('Deskripsi ringkas pencarian Google...')
                                    ->rows(3)
                                    ->maxLength(255),

                                TextInput::make('meta_keywords')
                                    ->label('Meta Keywords')
                                    ->placeholder('Kata kunci (pisahkan dengan koma)...')
                                    ->maxLength(255),
                            ]),
                    ])->columnSpan(1),
                ]),
            ]);
    }
}
