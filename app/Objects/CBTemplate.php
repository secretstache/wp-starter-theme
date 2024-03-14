<?php

namespace App\Objects;

/**
 * Add Content Block Template CPT
 */
add_action( 'init', function() {

    register_extended_post_type( "cb_template", [

        "capability_type"   => "page",
        "menu_icon"         => "dashicons-image-filter",
        "menu_position"		=> 5,
        "supports" 			=> [ "title" ],
        "show_in_menu"      => 'ssm',
        "has_archive"       => false,
        "public"            => false,
        "show_ui"           => true,

        "labels"            => [
            "all_items"     => "Content Block Templates",
        ],

        "admin_cols"        => [ // admin posts list columns
            "title"
        ],

    ], [

        "singular"  => "Content Block Template",
        "plural"    => "Content Block Templates",
        "slug"      => "template"

    ] );

});

/**
 * Register Meta Box
 */
add_action('add_meta_boxes', function () {

    add_meta_box('wrs-template-code', 'Shortcode', function () {
        global $post;
        echo '[wrs_template id=' . $post->ID . ']';
    }, ['cb_template', 'mb_template'], 'side');
    
});

/**
 * Register Shortcode
 */
add_shortcode('wrs_template', function ($atts) {

    if (isset($atts['id']) && ($post_id = (int)$atts['id'])) {

        $view = get_post_type($post_id) == 'mb_template' ? 'module-template' : 'content-block-template';

        $args = get_post_type($post_id) == 'mb_template' ? ['context' => 'mb_template', 'module' => ['context' => 'cb_template', 'module_id' => $post_id]] : ['template' => ['context' => 'cb_template', 'template_id' => $post_id]];

        return \Roots\view('templates.' . $view, $args)->render();
    }

});