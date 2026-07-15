<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use App\Models\ContactMessage;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->weight(fn (ContactMessage $record) => $record->is_read ? null : 'bold'),

                TextColumn::make('email')
                    ->label('Alamat Email')
                    ->searchable()
                    ->weight(fn (ContactMessage $record) => $record->is_read ? null : 'bold'),

                TextColumn::make('whatsapp_number')
                    ->label('Nomor WhatsApp')
                    ->searchable()
                    ->weight(fn (ContactMessage $record) => $record->is_read ? null : 'bold'),

                TextColumn::make('subject')
                    ->label('Subjek')
                    ->searchable()
                    ->weight(fn (ContactMessage $record) => $record->is_read ? null : 'bold'),

                TextColumn::make('message')
                    ->label('Pesan')
                    ->searchable()
                    ->limit(50)
                    ->weight(fn (ContactMessage $record) => $record->is_read ? null : 'bold'),

                TextColumn::make('created_at')
                    ->label('Diterima Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->weight(fn (ContactMessage $record) => $record->is_read ? null : 'bold'),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('15s')
            ->filters([
                SelectFilter::make('is_read')
                    ->label('Status Baca')
                    ->options([
                        '0' => 'Belum Dibaca',
                        '1' => 'Sudah Dibaca',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('reply_whatsapp')
                    ->label('WA')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(function (ContactMessage $record) {
                        $phone = preg_replace('/[^0-9]/', '', $record->whatsapp_number);
                        if (str_starts_with($phone, '0')) {
                            $phone = '62'.substr($phone, 1);
                        }

                        $text = 'Halo '.$record->name.",\n\nTerima kasih telah menghubungi kami melalui website Herro Equipment Rentals.\n\nAda yang bisa kami bantu?";

                        return "https://wa.me/{$phone}?text=".urlencode($text);
                    })
                    ->openUrlInNewTab(),
                Action::make('reply_email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope')
                    ->color('info')
                    ->url(function (ContactMessage $record) {
                        $subject = urlencode('Balasan: '.($record->subject ?? 'Pesan Website Herro'));
                        $body = urlencode('Halo '.$record->name.",\n\nTerima kasih telah menghubungi kami.\n\n");

                        return "mailto:{$record->email}?subject={$subject}&body={$body}";
                    })
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
