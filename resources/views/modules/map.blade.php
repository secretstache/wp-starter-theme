<div {!! $module_id !!} class="module map{!! $module_classes !!}">

    @if ($physical_address)

        <div id="map">
            <iframe class="gmap" src="https://www.google.com/maps?q={!! $builder->getMapAddress( $physical_address ) !!}&output=embed"></iframe>
        </div>

        <a target="_blank" class="get-directions" href="https://maps.google.com/?q={!! $builder->getMapAddress( $physical_address ) !!}">Get Directions</a>

    @endif

</div>
