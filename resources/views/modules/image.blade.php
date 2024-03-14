<picture {!! $module_id !!} class="module image{!! $module_classes !!}">

    @if ( $image )
            
        @if (!empty($image_link))
            <a href="{!! $image_link !!}" target="{!! $image_target !!}">
        @endif
                
            @if (function_exists('ipq_get_theme_image'))

                {!! 
                    ipq_get_theme_image( $image['ID'], 
                        [
                            [ 1200, 9999, true ],
                            [ 2400, 9999, true ],
                            [ 4800, 9999, true ],
                        ],
                        [                                
                            'class' => 'default-img',
                            'alt'   => $image['alt'] ?: 'Default Image'
                        ]
                    );                            
                !!}

            @endif

        @if (!empty($image_link))
            </a>
        @endif

    @endif

</picture>