<?php

namespace App\Filament\Resources\Faqs\Pages;

use App\Filament\Resources\Faqs\FaqResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Traits\RedirectsToIndex;

class ListFaqs extends ListRecords
{
    use RedirectsToIndex;
    protected static string $resource = FaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
