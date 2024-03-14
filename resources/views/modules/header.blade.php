<header {!! $module_id !!} class="module header{!! $module_classes !!}">
    
    @if ($headline_items)

        @foreach ($headline_items as $item)
            
            <{{ $item['headline_tag'] }} class="header__headline {!! $item['headline_class'] !!}">{!! $item['headline'] !!}</{{ $item['headline_tag'] }}>

        @endforeach

    @endif

</header>