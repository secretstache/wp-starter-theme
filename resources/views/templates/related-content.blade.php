<section {!! $id !!} class="content-block template-related-content{!! $classes !!}">

    <div class="grid-container">

        <div class="grid-x grid-margin-x align-center">

            <div class="cell small-11 medium-10">

                @php

                    if ( $template['query'] == 'latest' ) {

                        $args = [
                            'post_type'      => 'post',
                            'posts_per_page' => -1,
                            'status'         => 'publish',
                            'fields' 	     => 'ids',
                        ];

                        $posts = get_posts( $args );

                    } elseif ( $template['query'] == 'type' && $template['type'] ) {

                        $args = [
                            'post_type'      => 'post',
                            'posts_per_page' => -1,
                            'status'         => 'publish',
                            'fields' 	     => 'ids',
                            'tax_query'      => [
                                [
                                    'taxonomy'		=> 'mrm_resource_type',
                                    'field'         => 'slug',
                                    'terms'			=> [ $template['type']->slug ],
                                ]
                            ]
                        ];

                        $posts = get_posts( $args );

                    } elseif ( $template['query'] == 'solution' && $template['resource_solution'] ) {

                        $meta_queries['relation'] = 'OR';

                        foreach( $template['resource_solution'] as $key => $value ) {
                            $meta_queries[] = [
                                'key'       => 'resource_solutions',
                                'value'     => $value,
                                'compare'   => 'LIKE',
                            ];
                        }

                        $args = [
                            'post_type'     => 'post',
                            'posts_per_page' => -1,
                            'status'        => 'publish',
                            'fields' 	    => 'ids',
                            'meta_query'    => $meta_queries
                        ];

                        $posts = get_posts( $args );

                    } elseif ( $template['query'] == 'curated' ) {

                        $args = [
                            'post_type'     => 'post',
                            'status'        => 'publish',
                            'fields'        => 'ids',
                            'post__in'      => $template['resources_to_show']
                        ];

                        $posts = get_posts( $args );

                    }

                @endphp

                @if ( !empty( $posts ) )

                    @foreach ( $posts as $post_id )

                        <div class="grid-x grid-margin-x item">

                            <div class="cell small-12 medium-6">

                                <img src="{!! get_the_post_thumbnail_url( $post_id ) !!}" alt="">

                            </div>
        
                            <div class="cell small-12 medium-6">
        
                                <h2>{!! get_the_title( $post_id ) !!}</h2>
        
                                {!! get_post_field( 'post_content', $post_id ) !!}
        
                                <a href="{!! get_permalink( $post_id ) !!}" class="button">Read More</a>

                            </div>

                        </div>
                        
                    @endforeach

                @endif

            </div>

        </div>

    </div>

</section>