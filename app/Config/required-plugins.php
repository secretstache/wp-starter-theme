<?php

$required_plugins = [];

$json = json_decode( file_get_contents( get_template_directory( __FILE__ ) . '/app/Config/required-plugins.json' ) );
$json_plugins = array_column( $json, 'slug' );

if( ( $default_plugins = get_field( 'default_plugins', 'options' ) ) && !empty( $default_plugins ) ) {

    foreach( $default_plugins as $default_plugin ) {

        if( in_array( $default_plugin, $json_plugins ) && array_search( $default_plugin, $json_plugins ) !== false ) {

            array_push( $required_plugins, (array)$json[array_search( $default_plugin, $json_plugins )] );

        }

    }
    
}

if( ( $seo_plugin = get_field( 'seo_plugin', 'options' ) ) && ( $seo_plugin_name = $seo_plugin['plugin_name'] ) ) {

    if( in_array( $seo_plugin_name, $json_plugins ) && array_search( $seo_plugin_name, $json_plugins ) !== false ) {
        
        array_push( $required_plugins, (array)$json[array_search( $seo_plugin_name, $json_plugins )] );

        if( $seo_plugin_name == 'seo-by-rank-math' && ( $seo_by_rank_math_pro_key = array_search( 'seo-by-rank-math-pro', $json_plugins ) ) ) {
            array_push( $required_plugins, (array)$json[$seo_by_rank_math_pro_key] );
        }

    }

}

if( ( $form_plugin = get_field( 'form_plugin', 'options' ) ) && ( $form_plugin_name = $form_plugin['plugin_name'] ) ) {

    if( $form_plugin_name != 'hubspotforms' && ( $gravity_plugin_key = array_search( 'gravityforms', $json_plugins ) ) ) {
        
        array_push( $required_plugins, (array)$json[$gravity_plugin_key] );

        if( $acf_gravity_addon_key = array_search( 'acf-gravityforms-add-on', $json_plugins ) ) {
            array_push( $required_plugins, (array)$json[$acf_gravity_addon_key] );
        }

    }

}

if( ( $custom_plugins = get_field( 'custom_plugins', 'options' ) ) && !empty( $custom_plugins ) ) {

    foreach( $custom_plugins as $plugin ) {

        $custom_plugin = [
            "name"              => $plugin['name'],
            "slug"              => $plugin['slug'],
            "required"          => $plugin['is_required'],
            "force_activation"  => $plugin['is_required']
        ];

        if( $plugin['source'] == 'external' && $plugin['external_url'] ) {
            $custom_plugin['source'] = $plugin['external_url'];
        }

        array_push( $required_plugins, $custom_plugin );

    }

}

return $required_plugins;