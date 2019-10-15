<a class="embed-link" href="{{$link}}" target="_blank" rel="nofollow">
    @if($meta['image']['url'])
        <img class="embed-link__image" src="{!! $meta['image']['url'] !!}">
    @endif

    <div class="embed-link__title">
        {!! $meta['title'] !!}
    </div>

    <div class="embed-link__description">
        {!! $meta['description'] !!}
    </div>

    <span class="embed-link__domain">
        {!! parse_url($link, PHP_URL_HOST) !!}
    </span>
</a>