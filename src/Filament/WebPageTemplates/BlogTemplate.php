<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\WebPages\Filament\WebPageTemplates;
  
use Callcocam\WebPages\Contracts\WebPageTemplate;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

final class BlogTemplate implements WebPageTemplate
{
    public static function title(): string
    {
        return 'Simple Blog';
    }

    public static function schema(): array
    {
        return [
            Section::make()
                ->schema([
                    MarkdownEditor::make('content')
                        ->label(__('Content')),
                    TextInput::make('author'),
                ]),
        ];
    }
}
