<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\WebPages\Filament\Pages;

use Filament\Pages\Page;
use Callcocam\WebPages\Models\Page as ModelsPage;
use Filament\Panel;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Route;

class WebPage extends Page
{

    protected static string $view = 'web-pages::pages';     
    
    protected static string $layout = 'web-pages::layout.app';   

    protected ?string $heading = null;

    protected ?string $subheading = null;

    protected $pageData;

    protected static $staticPageData = null;

    public function mount(ModelsPage $page = null)
    { 
        if ($page instanceof ModelsPage) {
            $this->setPage($page);
        } else {
            if ($page = ModelsPage::where('slug', $page)->first()) {            
                $this->setPage($page);
            }
        }
    }

    public function setPage($page)
    {
        if ($page instanceof ModelsPage) {
            $this->pageData = $page;
            $this->heading = $page->plural_name;
            $this->subheading = $page->description;
            static::$staticPageData = $page;
            if ($icon = $page->pageGroup->icon) {
                static::$navigationIcon = $icon;
            } else {
                static::$navigationIcon = $page->icon;
            }
        }
    }

    public function getTitle(): string | Htmlable
    {
        if ($this->pageData) {
            return $this->pageData->plural_name;
        }
        return __('Custom Page Title');
    }

    public static function routes(Panel $panel): void
    {
        $slug = static::getSlug();

        Route::get("/{page}", static::class)
            ->middleware(static::getRouteMiddleware($panel))
            ->withoutMiddleware(static::getWithoutRouteMiddleware($panel))
            ->name((string) str($slug)->replace('/', '.'));
    }

     /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'pageData' => $this->pageData, 
            'content' =>data_get(static::$staticPageData, 'data.content.content'),
            'template' =>data_get(static::$staticPageData, 'data.template'),
            'templateName' =>data_get(static::$staticPageData, 'data.template_name'),
        ];
    }

     
 
}
