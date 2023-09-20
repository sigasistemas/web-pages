<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\WebPages\Filament\WebPageTemplates;

use Callcocam\WebPages\Contracts\WebPageTemplate; 
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;

final class DefaultTemplate implements WebPageTemplate
{
    public static function title(): string
    {
        return 'Simple Page';
    }

    public static function schema(): array
    {
        return [
            Section::make()
                ->schema([
                    RichEditor::make('content')
                        ->label(__('Content')),
                ]),
        ];
    }
}
