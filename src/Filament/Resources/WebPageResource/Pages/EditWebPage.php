<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\WebPages\Filament\Resources\WebPageResource\Pages;

use Callcocam\WebPages\Filament\Resources\WebPageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWebPage extends EditRecord
{
    public static function getResource(): string
    {
        return config('filament-pages.filament.resource', WebPageResource::class);
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
