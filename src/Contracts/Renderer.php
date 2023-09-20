<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\WebPages\Contracts;

use Callcocam\WebPages\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

interface Renderer
{
    public function render(Page $filamentPage): Response|View;
}
