<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // ================= GALLERY INFO =================
            TextInput::make('title')
                ->label('Judul')
                ->placeholder('Masukkan judul gallery')
                ->helperText('Judul gallery.')
                ->required()
                ->maxLength(255),

            Textarea::make('description')
                ->label('Deskripsi')
                ->placeholder('Masukkan deskripsi gallery')
                ->helperText('Deskripsi gallery.')
                ->columnSpanFull(),

            TagsInput::make('tags')
                ->label('Tags')
                ->placeholder('Tambah tag…')
                ->helperText('Tags untuk kategori.')
                ->columnSpanFull(),

            // ================= MEDIA =================
            \App\Support\FilamentImagePicker::make(
                fieldName: 'thumbnail',
                label: 'Thumbnail',
                directory: 'galleries/thumbnails',
                prefix: 'gallery-cover',
                helperText: 'Thumbnail / cover gallery. Maks: 5MB.'
            ),

            \App\Support\FilamentImagePicker::make(
                fieldName: 'images',
                label: 'Foto Gallery',
                directory: 'galleries/images',
                prefix: 'gallery',
                multiple: true,
                helperText: 'Unggah beberapa gambar gallery. Maks: 5MB per file.'
            )->columnSpanFull(),

            // ================= SETTINGS =================
            Toggle::make('is_published')
                ->label('Publish?')
                ->helperText('Jika aktif, gallery tampil di halaman publik.')
                ->default(false),

            TextInput::make('order_column')
                ->label('Urutan')
                ->placeholder('0')
                ->helperText('Semakin kecil, semakin atas posisinya.')
                ->numeric()
                ->default(0)
                ->required(),
        ]);
    }
}
