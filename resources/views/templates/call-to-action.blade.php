<section {!! $id !!} class="content-block template-cta{!! $classes !!}">

    @if ( $template["option_background"] == "image" || $template["option_background"] == "video" )
        <div class="overlay"></div>
    @endif

    <div class="grid-container">

        <div class="grid-x grid-margin-x align-center">

            <div class="cell small-11 medium-12">

                <div class="inner">

                    <div class="content">

                        @if ($template['headline'])
                            <h2 class="headline">{!! $template['headline'] !!}</h2>
                        @endif

                        @if ($template['subheadline'])
                            <h3 class="subheadline">{!! $template['subheadline'] !!}</h3>
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
