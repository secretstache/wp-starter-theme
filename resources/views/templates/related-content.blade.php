<section {!! $id !!} class="content-block template-related-content{!! $classes !!}">

    <div class="grid-container">

        <div class="grid-x grid-margin-x align-center">

            <div class="cell small-11 medium-10">

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