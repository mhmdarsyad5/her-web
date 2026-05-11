<?php

namespace App\Filament\Resources\HeroSections\Pages;

use App\Filament\Resources\HeroSections\HeroSectionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Traits\RedirectsToIndex;

class EditHeroSection extends EditRecord
{
    use RedirectsToIndex;
    protected static string $resource = HeroSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
