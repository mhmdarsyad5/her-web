<?php

namespace App\Support;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Schemas\Components\Grid;

class FilamentImagePicker
{
    public static function make(
        string $fieldName,
        string $label,
        string $directory,
        int $maxWidth = 1200,
        int $quality = 80,
        string $prefix = '',
        bool $isPurePrefix = false,
        bool $multiple = false,
        ?string $helperText = null,
        bool $required = false
    ): Grid {
        $sourceFieldName = $fieldName.'_source';
        $uploadFieldName = $fieldName.'_upload';
        $selectFieldName = $fieldName.'_select';

        return Grid::make(1)
            ->schema([
                Hidden::make($fieldName)
                    ->reactive()
                    ->required($required),

                Radio::make($sourceFieldName)
                    ->label($label.' - Sumber')
                    ->options([
                        'upload' => 'Unggah Baru',
                        'server' => 'Pilih dari Galeri (Gambar yang Sudah Ada)',
                    ])
                    ->default('upload')
                    ->afterStateHydrated(function ($component, $state, $set) {
                        if (blank($state)) {
                            $set($component->getName(), 'upload');
                        }
                    })
                    ->reactive()
                    ->helperText($helperText)
                    ->dehydrated(false),

                FileUpload::make($uploadFieldName)
                    ->label($label)
                    ->directory($directory)
                    ->disk('public')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                    ->validationMessages([
                        'mimetypes' => 'Format file tidak didukung.',
                        'mimes' => 'Format file tidak didukung.',
                    ])
                    ->maxSize(5120) // 5MB
                    ->optimizeToWebp($maxWidth, $quality, $prefix, $isPurePrefix)
                    ->multiple($multiple)
                    ->reorderable()
                    ->imageEditor()
                    ->helperText($helperText)
                    ->dehydrated(false)
                    ->afterStateHydrated(function ($component, $get, $set) use ($fieldName) {
                        $val = $get($fieldName);
                        if ($val) {
                            $set($component->getName(), $val);
                        }
                    })
                    ->afterStateUpdated(function ($state, $set) use ($fieldName) {
                        $set($fieldName, $state);
                    })
                    ->visible(fn ($get) => ($get($sourceFieldName) ?? 'upload') === 'upload'),

                \Filament\Forms\Components\Placeholder::make($selectFieldName)
                    ->hiddenLabel()
                    ->content(fn ($component) => view('filament.components.gallery-picker', [
                        'statePath' => $component->getContainer()->getStatePath().'.'.$fieldName,
                        'uploadStatePath' => $component->getContainer()->getStatePath().'.'.$uploadFieldName,
                        'stateValue' => $component->evaluate(fn ($get) => $get($fieldName)),
                        'fieldName' => $fieldName,
                        'directory' => $directory,
                        'multiple' => $multiple,
                    ]))
                    ->dehydrated(false)
                    ->visible(fn ($get) => $get($sourceFieldName) === 'server'),
            ]);
    }
}
