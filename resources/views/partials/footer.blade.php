<footer class="site-footer">

	<div class="grid-container">

		<div class="site-footer__top">

			<div class="site-footer__info">

				<div class="site-footer__socials">

					<ul>

						@if ( $twitter = $social_networks['twitter'] )
							<li><a href="{!! $twitter !!}" target="_blank"><img src="@asset('images/twitter-icon.svg')" alt="Twitter"></a></li>
						@endif

						@if ( $facebook = $social_networks['facebook'] )
							<li><a href="{!! $facebook !!}" target="_blank"><img src="@asset('images/facebook-icon.svg')" alt="Facebook"></a></li>
						@endif

						@if ( $instagram = $social_networks['instagram'] )
							<li><a href="{!! $instagram !!}" target="_blank"><img src="@asset('images/instagram-icon.svg')" alt="Instagram"></a></li>
						@endif

						@if ( $linkedin = $social_networks['linkedin'] )
							<li><a href="{!! $linkedin !!}" target="_blank"><img src="@asset('images/linkedin-icon.svg')" alt="LinkedIn"></a></li>
						@endif

					</ul>

				</div>

			</div>

			@if ( !empty( $footer['menus'] ) && $footer['menus'] )
				
				<div class="site-footer__navigation">

					@foreach ($footer['menus'] as $menu )

						@php wp_nav_menu( $builder->getMenuArgs('menu_id', $menu['nav_menu'] ) ); @endphp

					@endforeach

				</div>

			@endif

		</div>

		<div class="site-footer__bottom">

			<div class="site-footer__logo">

				@if ( ( $brand_logo = $logo_assets['brand_logo'] ) && $brand_logo['url'] )
								
					<a href="{!! home_url() !!}">
						<img src="{!! $brand_logo['url'] !!}" class="editable-svg" alt="{!! $brand_logo['alt'] ?: get_bloginfo('name') !!}">
					</a>

				@endif

			</div>

			<div class="site-footer__terms">

				@if ( $footer['copyright'] )
					{!! $footer['copyright'] !!}
				@endif

				@if ( has_nav_menu('legal_navigation') )

					<nav class="site-footer__terms__navigation">

						@php wp_nav_menu( $builder->getMenuArgs('legal_navigation') ); @endphp
								
					</nav>

				@endif

			</div>

		</div>

	</div>

</footer>