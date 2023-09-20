<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\WebPages\Filament\Pages;


use Filament\Pages\Page;
use Callcocam\WebPages\Models\Page as ModelsPage;
use Illuminate\Contracts\Support\Htmlable;

class WebPage extends Page
{

    protected $pageData;

    protected static $staticPageData = null;

    public function mount($page = null)
    {
        if ($page instanceof ModelsPage) {
            $this->setPage($page);
        } else {
            if ($page = ModelsPage::where('slug', static::getSlug())->first()) {
                $this->setPage($page);
            }
        }
    }


    public function setPage($page)
    {
        if ($page instanceof ModelsPage) {
            $this->pageData = $page;
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

    // public static function getNavigationGroup(): ?string
    // {
    //     if ($page = static::$staticPageData) { 
    //         return $page->pageGroup->plural_name;
    //     }
    //     return static::$navigationGroup;
    // }
}
