<?php

namespace App\Filament\Resources\Seos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class SeoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('page')
                    ->label('Page Identifier')
                    ->placeholder('Contoh: home, about, contact')
                    ->helperText('Gunakan nama unik untuk mengidentifikasi halaman. Contoh: "home", "about", "contact", "services".')
                    ->required(),

                TextInput::make('meta_title')
                    ->label('Meta Title')
                    ->placeholder('Contoh: Jasa Rental Alat Berat Terpercaya')
                    ->helperText('Judul SEO yang muncul di tab browser dan hasil pencarian. Maksimal 60 karakter.')
                    ->maxLength(60)
                    ->default(null),

                Textarea::make('meta_description')
                    ->label('Meta Description')
                    ->placeholder('Contoh: Kami adalah jasa rental alat berat terpercaya yang menyediakan solusi untuk kebutuhan Anda.')
                    ->helperText('Deskripsi singkat halaman untuk hasil pencarian Google. Maksimal 160 karakter.')
                    ->maxLength(160)
                    ->rows(3)
                    ->default(null)
                    ->columnSpanFull(),

                FileUpload::make('og_image')
                    ->label('Open Graph Image')
                    ->placeholder('Unggah gambar untuk preview di sosial media')
                    ->helperText('Gambar yang digunakan saat halaman dibagikan ke sosial media. Ukuran ideal: 1200x630px.')
                    ->disk('public')
                    ->directory('seo')
                    ->preserveFilenames()
                    ->enableOpen()
                    ->enableDownload()
                    ->image()
                    ->columnSpanFull(),
            ]);
    }
}
