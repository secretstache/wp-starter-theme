@if( $modules )

    @foreach( $modules as $module )

        @if ( $module['acf_fc_layout'] == 'module-template' )

            @include( 'templates.module-template', [ 'module' => $module ] )
            
        @else 

            @if ($module['option_status'])

                @include( 'modules.' . $module['acf_fc_layout'] )

            @endif

        @endif

    @endforeach

@endif