<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\WebPages\Filament\Resources\PageWidgetStatResource\Pages;

use Callcocam\WebPages\Filament\Resources\WebPageWidgetStatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPageWidgetStats extends ListRecords
{
    protected static string $resource = WebPageWidgetStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
