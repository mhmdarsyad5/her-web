<?php

namespace App\Filament\Resources\PartnerResource\Pages;

use App\Filament\Resources\PartnerResource;
use Filament\Resources\Pages\CreateRecord;
use App\Traits\RedirectsToIndex;

class CreatePartner extends CreateRecord
{
    use RedirectsToIndex;

    protected static string $resource = PartnerResource::class;
}
