@if( $templates = get_field( 'templates', $template['template_id'] ) )

    @foreach( $templates as $template )
        
        @if( $template['option_status'] )

            @include( 'templates.' . $template['acf_fc_layout'] )

        @endif

    @endforeach

@endif