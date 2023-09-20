<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\WebPages\Contracts;

interface WebPageTemplate
{
    public static function title(): string;

    public static function schema(): array;
}
