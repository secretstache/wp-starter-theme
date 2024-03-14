@if ( $modules_template = get_field( 'modules', $module['module_id'] ) )

    @foreach ( $modules_template as $module )

        @if ($module['option_status'])

            @include( 'modules.' . $module['acf_fc_layout'] )

        @endif

    @endforeach
    
@endif