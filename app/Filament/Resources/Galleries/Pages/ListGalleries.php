<?php

namespace App\Filament\Resources\Galleries\Pages;

use App\Filament\Resources\Galleries\GalleryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Traits\RedirectsToIndex;

class ListGalleries extends ListRecords
{
    use RedirectsToIndex;
    protected static string $resource = GalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
