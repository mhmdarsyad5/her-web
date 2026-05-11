<?php

namespace App\Filament\Resources\Settings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')

            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),

                TextColumn::make('key')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'core'     => 'gray',     // tetap gray
                        'branding' => 'primary',  // purple ≈ primary (atau info untuk lebih biru-ungu)
                        'theme'    => 'info',     // indigo ≈ info (biru keunguan)
                        'layout'   => 'primary',  // blue ≈ primary
                        'sections' => 'success',  // emerald (hijau) ≈ success
                        'content'  => 'warning',  // amber (kuning/orange) ≈ warning
                        'system'   => 'danger',   // rose (merah pink) ≈ danger
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst($state)),

                TextColumn::make('type')
                    ->badge(),

                TextColumn::make('value')
                    ->formatStateUsing(function ($state) {
                        if (is_array($state)) {
                            $text = $state['id'] ?? ($state['path'] ?? ($state['color'] ?? json_encode($state)));
                            return Str::of($text)->stripTags()->squish();
                        }
                        return Str::of((string) $state)->stripTags()->squish();
                    })
                    ->limit(40),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                SelectFilter::make('category')
                    ->label('Category')
                    ->options([
                        'general'   => 'General',
                        'branding'  => 'Branding',
                        'theme'     => 'Theme & Color',

                        'navbar'    => 'Navbar',
                        'footer'    => 'Footer',

                        'hero'      => 'Hero Section',
                        'about'     => 'About Section',

                        'pages'     => 'Pages',
                        'services'  => 'Services',
                        'galleries' => 'Galleries',
                        'faq'       => 'FAQ',

                        'seo'       => 'SEO',
                        'legal'     => 'Legal',

                        'contact'   => 'Contact',
                        'social'    => 'Social Media',
                    ])
                    ->searchable()
                    ->indicator('Category'),
            ])

            ->recordActions([
                EditAction::make(),
            ])

            ->toolbarActions([
                // bulk delete sengaja dimatikan (settings rawan)
            ]);
    }
}
