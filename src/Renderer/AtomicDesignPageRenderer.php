<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\WebPages\Renderer;

use Callcocam\WebPages\Contracts\Renderer;
use Callcocam\WebPages\Exceptions\WebPageDesignPageRendererException;
use Callcocam\WebPages\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WebDesignPageRenderer implements Renderer
{
    public function render(Page $filamentPage): View
    {
        $template = $this->computeTemplateName($filamentPage);

        $components = $this->getComponents($filamentPage);

        return view($template, compact('components'));
    }

    private function computeTemplateName(Page $filamentPage): string
    {
        $data = $filamentPage->data;

        if (! isset($data['templateName']) || blank($data['templateName'])) {
            throw new WebPageDesignPageRendererException(
                message: 'Key templateName is not set in data.'
            );
        }

        $template = str_replace('_template', '', $data['templateName']);

        return "components.templates.{$template}";
    }

    /**
     * @param  array  $data
     * @return array
     */
    private function getComponents(Page $filamentPage): array
    {
        $data = $filamentPage->data;

        if (! isset($data['content']) || blank($data['content'])) {
            throw new WebPageDesignPageRendererException(
                message: sprintf('key "%s" does not exist in given data.', 'content')
            );
        }

        $components = [];

        foreach ($data['content'] as $key => $component) {
            $components[$key] = $this->createComponent(name: $key, content: $component);
        }

        return $components;
    }

    private function createComponent(string $name, $content): Component
    {
        return new class($name, $content) extends Component
        {
            public function __construct(public readonly string $name, public readonly mixed $content)
            {
            }

            public function render(): View
            {
                return view("components.organisms.{$this->name}", ['content' => $this->content]);
            }
        };
    }
}
