<section {!! $id !!} class="content-block template-free-form{!! $classes !!}">
    
    @if( $template['columns'] )

        <div class="grid-container">

            <div class="grid-x{!! $container_width . $container_alignment . $column_alignment_x . $column_alignment_y !!}">

                @foreach( $template['columns'] as $key => $column )

                    @php
                        $mobile_order = ($column_mobile_order && isset($column_mobile_order[$key])) ? ' small-order-' . $column_mobile_order[$key] : '';
                        $medium_width = ($column_width && isset($column_width[$key])) ? ' medium-' . $column_width[$key] : '';
                    @endphp

                    <div {!! $column_options[$key]['id'] !!} class="cell{!! $mobile_order !!}{!! $medium_width !!}{!! $column_options[$key]['classes'] !!}">

                        <div class="cell__inner">

                            @include('modules', [ 'modules' => $column['modules'] ] )

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    @endif

</section>