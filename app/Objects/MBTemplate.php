<?php

namespace App\Objects;

/**
 * Add Module Template CPT
 */
add_action( 'init', function() {

    register_extended_post_type( "mb_template", [

        "capability_type"   => "page",
        "menu_icon"         => "dashicons-image-filter",
        "menu_position"		=> 5,
        "supports" 			=> [ "title" ],
        "show_in_menu"      => 'ssm',
        "has_archive"       => false,
        "public"            => false,
        "show_ui"           => true,

        "labels"            => [
            "all_items"     => "Module Templates",
        ],

        "admin_cols"        => [
            "title"
        ],

    ], [

        "singular"  => "Module Template",
        "plural"    => "Module Templates",
        "slug"      => "module"

    ] );

}); 