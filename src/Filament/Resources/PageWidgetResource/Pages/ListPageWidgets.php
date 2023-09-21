<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\WebPages\Filament\Resources\PageWidgetResource\Pages;

use Callcocam\WebPages\Filament\Resources\WebPageWidgetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPageWidgets extends ListRecords
{
    protected static string $resource = WebPageWidgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
