<?php

namespace App\Traits;

trait RedirectsToIndex
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
