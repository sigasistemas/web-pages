<x-web-pages::page>
{{ \Filament\Support\Facades\FilamentView::renderHook('panels::page.dashboard', scopes: [static::class, \App\Filament\Resources\BannerResource::class]) }}
   @isset($content)
        @if($content)
        {!! $content !!}
        @endif
    @endisset
</x-web-pages::page>