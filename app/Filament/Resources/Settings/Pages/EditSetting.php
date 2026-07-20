<?php

namespace App\Filament\Resources\Settings\Pages;

use App\Filament\Resources\Settings\SettingResource;
use App\Traits\RedirectsToIndex;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cache;

class EditSetting extends EditRecord
{
    use RedirectsToIndex;

    protected static string $resource = SettingResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (($data['type'] ?? null) === 'color' && is_string($data['value'] ?? null)) {
            $data['value'] = [
                'color' => $data['value'],
            ];
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->disabled(
                    fn ($record) => in_array($record->key, ['primary_color'])
                )
                ->tooltip('System settings cannot be deleted.'),
        ];
    }

    protected function afterSave(): void
    {
        Cache::forget('settings.all');
        Cache::forget('settings.url.'.$this->record->key);

        \App\Support\ActivityLogger::log('update', 'Mengubah setting key: '.$this->record->key, 'Setting', (string) $this->record->key);
    }

    protected function afterDelete(): void
    {
        Cache::forget('settings.all');
        Cache::forget('settings.url.'.$this->record->key);

        \App\Support\ActivityLogger::log('delete', 'Menghapus setting key: '.$this->record->key, 'Setting', (string) $this->record->key);
    }
}
