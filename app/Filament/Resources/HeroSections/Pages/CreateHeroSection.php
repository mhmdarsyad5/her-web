<?php

namespace App\Filament\Resources\HeroSections\Pages;

use App\Filament\Resources\HeroSections\HeroSectionResource;
use Filament\Resources\Pages\CreateRecord;
use App\Traits\RedirectsToIndex;

class CreateHeroSection extends CreateRecord
{
    use RedirectsToIndex;
    protected static string $resource = HeroSectionResource::class;
}
