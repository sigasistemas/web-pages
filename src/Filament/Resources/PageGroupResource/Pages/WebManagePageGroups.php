<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\WebPages\Filament\Resources\PageGroupResource\Pages;

use Callcocam\WebPages\Filament\Resources\WebPageGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class WebManagePageGroups extends ManageRecords
{
    protected static string $resource = WebPageGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
