<?php

namespace App\Filament\Resources\Faqs\Pages;

use App\Filament\Resources\Faqs\FaqResource;
use App\Traits\RedirectsToIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateFaq extends CreateRecord
{
    use RedirectsToIndex;

    protected static string $resource = FaqResource::class;
}
