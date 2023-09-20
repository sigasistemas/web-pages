<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\WebPages\Filament\Resources\WebPageResource\Pages;

use Callcocam\WebPages\Filament\Resources\WebPageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWebPages extends ListRecords
{
    public static function getResource(): string
    {
        return config('filament-pages.filament.resource', WebPageResource::class);
    }

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
