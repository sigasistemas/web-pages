<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\WebPages\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Callcocam\WebPages\WebPages
 */
class WebPages extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Callcocam\WebPages\WebPages::class;
    }
}
