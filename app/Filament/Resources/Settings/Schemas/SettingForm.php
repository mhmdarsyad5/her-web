<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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

            /**
             * ========= COLOR =========
             */
            Select::make('value.color')
                ->label('Color')
                ->options([
                    'red' => 'Red',
                    'orange' => 'Orange',
                    'amber' => 'Amber',
                    'yellow' => 'Yellow',
                    'lime' => 'Lime',
                    'green' => 'Green',
                    'emerald' => 'Emerald',
                    'teal' => 'Teal',
                    'cyan' => 'Cyan',
                    'sky' => 'Sky',
                    'blue' => 'Blue',
                    'indigo' => 'Indigo',
                    'violet' => 'Violet',
                    'purple' => 'Purple',
                    'fuchsia' => 'Fuchsia',
                    'pink' => 'Pink',
                    'rose' => 'Rose',
                    'gray' => 'Gray',
                    'zinc' => 'Zinc',
                    'neutral' => 'Neutral',
                    'stone' => 'Stone',
                ])
                ->visible(fn($get) => $get('type') === 'color')
                ->required(),

            /**
             * ========= TEXT (INDONESIAN ONLY) =========
             */
            RichEditor::make('value.id')
                ->label('Content / Value')
                ->visible(fn($get) => $get('type') === 'text')
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