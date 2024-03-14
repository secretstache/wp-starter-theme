@if(! post_password_required())

    @if( !empty($templates) && $templates )

		@foreach( $templates as $template )
			
			@if( $template['option_status'] )

				@include( 'templates.' . $template['acf_fc_layout'] )

			@endif

		@endforeach

    @endif
    
@else 

    @include( 'partials.password-form' )

@endif