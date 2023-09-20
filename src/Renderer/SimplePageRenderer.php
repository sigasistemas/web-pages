<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\WebPages\Renderer;

use Callcocam\WebPages\Contracts\Renderer;
use Callcocam\WebPages\Models\Page;
use Illuminate\Contracts\View\View;

class SimplePageRenderer implements Renderer
{
    public function render(Page $filamentPage): View
    {
        $layout = config('web-pages.default_layout', 'layouts.app');

        return view($layout, ['page' => $filamentPage, 'data' => $filamentPage->description['content'] ?? []]);
    }
}
