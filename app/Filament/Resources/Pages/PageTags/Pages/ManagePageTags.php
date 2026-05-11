<?php

namespace App\Filament\Resources\Pages\PageTags\Pages;

use App\Filament\Resources\Pages\PageTags\PageTagResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePageTags extends ManageRecords
{
    protected static string $resource = PageTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
