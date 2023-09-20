<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\WebPages\Filament;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;

trait HasIconsColumn
{

    public static function getIconsColumnLabel(): string
    {
        return 'Icons';
    }

    public static function getIconsTableIconColumn(): IconColumn
    {
        return  IconColumn::make(static::getIconsColumn())
            ->label(static::getIconsColumnLabel())
            ->icon(fn (string $state): string =>  $state);
    }

    public static function getIconsFormSelectField(bool $required = true): Field
    {
        if (class_exists('App\\Models\\Icon')) {

            return Select::make(static::getIconsColumn())
                ->label(static::getIconsColumnLabel())
                ->options(static::getIconses())
                ->placeholder('Selecione um Icone')
                ->searchable()
                ->reactive()
                ->suffixIcon(function (string| null $state = null) {
                    return $state;
                })
                ->default('heroicon-o-rectangle-stack')
                ->required($required);
        }

        return TextInput::make(static::getIconsColumn())
            ->label(static::getIconsColumnLabel())
            ->placeholder('Selecione um Icone') 
            ->default('heroicon-o-rectangle-stack')
            ->required($required);
    }


    public static function getIconses(): array
    {
        return  app('App\\Models\\Icon')::query()->pluck('name', 'icon')->toArray();
    }

    public static function getIconsColumn(): string
    {
        return 'icon';
    }

    public static function getIconsesForTable(): array
    {
        return static::getIconses();
    }

    public static function getIconsesForForm(): array
    {
        return  static::getIconses();
    }
}
