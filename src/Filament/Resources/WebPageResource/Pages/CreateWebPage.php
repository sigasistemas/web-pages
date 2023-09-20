<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\WebPages\Filament\Resources\WebPageResource\Pages;

use Callcocam\WebPages\Filament\Resources\WebPageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWebPage extends CreateRecord
{
    public static function getResource(): string
    {
        return config('web-pages.filament.resource', WebPageResource::class);
    }
}
