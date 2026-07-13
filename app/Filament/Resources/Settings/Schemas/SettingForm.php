<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            TextInput::make('key')
                ->required()
                ->disabled(fn($record) => $record !== null)
                ->rules([
                    fn($record) => Rule::unique('settings', 'key')
                        ->ignore($record?->id),
                ]),

            Select::make('category')
                ->label('Category')
                ->options([
                    'core'      => 'Core / General',
                    'branding'  => 'Branding',
                    'theme'     => 'Theme & Color',
                    'layout'    => 'Layout (Navbar, Footer, Badge, Button, etc)',
                    'sections'  => 'Sections (Hero, About, Services, Testimonials, etc)',
                    'content'   => 'Content (Pages, Services, FAQ, etc)',
                    'contact'   => 'Contact & Branches',
                    'system'    => 'System (SEO, Legal, Contact, Social Media, etc)',
                ])
                ->default('core')
                ->required()
                ->searchable(),

            Select::make('type')
                ->options([
                    'text'  => 'Text',
                    'image' => 'Image',
                    'video' => 'Video',
                    'color' => 'Color',
                ])
                ->required()
                ->reactive(),

            \Filament\Forms\Components\Toggle::make('value.is_active')
                ->label('Tampilkan / Aktifkan')
                ->default(true)
                ->helperText('Jika dinonaktifkan, elemen ini tidak akan ditampilkan di website.')
                ->visible(fn($get) => !in_array($get('key'), ['service_show_image', 'service_show_desc']))
                ->columnSpanFull(),

            /**
             * ========= BOOLEAN / TOGGLE (Kondisional Key) =========
             */
            \Filament\Forms\Components\Toggle::make('value.boolean_value')
                ->label('Status Aktif (On / Off)')
                ->visible(fn($get) => in_array($get('key'), ['service_show_image', 'service_show_desc']))
                ->default(true)
                ->columnSpanFull(),

            /**
             * ========= COLOR =========
             */
            \Filament\Forms\Components\ColorPicker::make('value.color')
                ->label('Color')
                ->visible(fn($get) => $get('type') === 'color')
                ->required(),

            /**
             * ========= TEXT (INDONESIAN ONLY) =========
             */
            TinyEditor::make('value.id')
                ->label('Content / Value')
                ->visible(fn($get) => $get('type') === 'text' && !in_array($get('key'), ['service_show_image', 'service_show_desc']))
                ->required()
                ->columnSpanFull(),

            /**
             * ========= FILE =========
             */
            FileUpload::make('value.path')
                ->label('File')
                ->visible(fn($get) => in_array($get('type'), ['image', 'video']))
                ->disk('public')
                ->directory('settings')
                ->getUploadedFileNameForStorageUsing(function ($file) {
                    return 'logo-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                })
                ->enableOpen()
                ->enableDownload()
                ->columnSpanFull(),
        ]);
    }
}