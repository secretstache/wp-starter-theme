<div {!! $module_id !!} class="module video{!! $module_classes !!}">

    @if ( $module['type'] == 'oembed' && $module['video_oembed'] )

        <div class="video__responsive-wrapper">

            @php $oembed = preg_replace('/src="(.+?)"/', 'src="$1&rel=0&playsinline=1"', $module['video_oembed']); @endphp

            {!! $oembed !!}

        </div>

    @elseif( $module['type'] == 'external' && $module['video_url'] )

        @php $poster_html = ( $module['fallback_image'] ) ? 'poster="'. $module['fallback_image']['url'] .'"' : ''; @endphp

        <video src="{!! $module['video_url'] !!}" controls {!! $poster_html !!}></video>

    @endif

</div>