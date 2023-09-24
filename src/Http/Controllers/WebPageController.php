<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\WebPages\Http\Controllers;

use App\Http\Controllers\Controller;
use Callcocam\WebPages\Contracts\Renderer;
use Callcocam\WebPages\Models\Page;
use Illuminate\Contracts\View\View;

class WebPageController extends Controller
{
    public function __construct(private readonly Renderer $renderer)
    {

    }

    public function show(Page $filamentPage): View
    {
        return $this->renderer->render($filamentPage);
    }
}
