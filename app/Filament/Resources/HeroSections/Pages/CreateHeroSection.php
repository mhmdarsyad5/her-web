<?php

namespace App\Filament\Resources\HeroSections\Pages;

use App\Filament\Resources\HeroSections\HeroSectionResource;
use App\Traits\RedirectsToIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateHeroSection extends CreateRecord
{
    use RedirectsToIndex;

    protected static string $resource = HeroSectionResource::class;
}
