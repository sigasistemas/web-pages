<x-web-pages::page>
   @isset($content)
        @if($content)
        {!! $content !!}
        @endif
    @endisset
</x-web-pages::page>