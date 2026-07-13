<?php

namespace App\Filament\Resources\PartnerResource\Pages;

use App\Filament\Resources\PartnerResource;
use App\Traits\RedirectsToIndex;
use Filament\Resources\Pages\CreateRecord;

class CreatePartner extends CreateRecord
{
    use RedirectsToIndex;

    protected static string $resource = PartnerResource::class;
}
