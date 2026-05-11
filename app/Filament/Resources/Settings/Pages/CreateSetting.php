<?php

namespace App\Filament\Resources\Settings\Pages;

use App\Filament\Resources\Settings\SettingResource;
use Filament\Resources\Pages\CreateRecord;
use App\Traits\RedirectsToIndex;
use Illuminate\Support\Facades\Cache;

class CreateSetting extends CreateRecord
{
    use RedirectsToIndex;

    protected static string $resource = SettingResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['value'] = match ($data['type']) {
            'text'  => $data['text_value'] ?? null,
            'color' => $data['color_value'] ?? null,
            'image', 'video' => $data['file_value'] ?? null,
            default => null,
        };

        unset(
            $data['text_value'],
            $data['color_value'],
            $data['file_value']
        );

        return $data;
    }

    protected function afterCreate(): void
    {
        Cache::forget('settings.all');
        Cache::forget('settings.url.' . $this->record->key);
    }
}
