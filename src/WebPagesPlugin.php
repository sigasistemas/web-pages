<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\WebPages;

use Callcocam\WebPages\Filament\Resources\WebPageWidgetResource;
use Callcocam\WebPages\Filament\Resources\WebPageGroupResource;
use Callcocam\WebPages\Filament\Resources\WebPageResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class WebPagesPlugin implements Plugin
{
    public function getId(): string
    {
        return 'web-pages';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            WebPageResource::class,
            WebPageGroupResource::class,
            WebPageWidgetResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
