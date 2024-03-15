<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use App\Includes\Walker;
use Roots\Acorn\View\Composers\Concerns\AcfFields;

class SSM extends Composer
{
    use AcfFields;

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {

        return [
            'builder' => $this->getBuilder(),
            'logo_assets'           => [
                'brand_logo'        => get_field('brand_logo', 'options'),
                'favicon'           => get_field('favicon', 'options')
            ],
            'business_information'  => [
                'phone_number'      => get_field( 'primary_phone_number', 'options' ),
                'email_address'     => get_field( 'primary_email_address', 'options' ),
                'physical_address'  => get_field( 'physical_address', 'options' )
            ],
            'social_networks'       => [
                'facebook'          => get_field( 'facebook', 'options' ),
                'twitter'           => get_field( 'twitter', 'options' ),
                'linkedin'          => get_field( 'linkedin', 'options' ),
                'instagram'         => get_field( 'instagram', 'options' )
            ],
            'footer'                => [
                'copyright'         => get_field( 'footer_copyright', 'options' )
            ],
            'is_landing_page'       => is_page_template('template-landing-page.blade.php')
        ];

    }

    public static function getMenuArgs($context, $menu_id = null)
    {

        $response = [
            "container"      => FALSE,
            "walker"         => new Walker()
        ];

        if ( $context == 'offcanvas' ) {

            $response['theme_location'] = 'primary_navigation';
            $response['items_wrap'] = '<ul class="menu menu--vertical">%3$s</ul>';
            
        } elseif ( $context == 'primary_navigation' ) {

            $response['theme_location'] = 'primary_navigation';
            $response['items_wrap'] = '<ul class="menu is-dropdown">%3$s</ul>';

        } elseif ( $context == 'legal_navigation' ) {

            $response['theme_location'] = 'legal_navigation';
            $response['items_wrap'] = '<ul>%3$s</ul>';

        } elseif ( $menu_id ) {

            $response['menu'] = $menu_id;
            $response['items_wrap'] = '<ul>%3$s</ul>';

        }

        return $response;

    }

    /**
     * Returns builder
     *
     * @return object
     */
    public function getBuilder() {
        return $this;
    }

    public static function getCustomID( $html_id )
    {
        return ( !empty( $html_id ) ) ? " id=\"". sanitize_html_class( strtolower( $html_id ) ) ."\"" : "";
    }

    public static function setSpacingSize( $value )
    {
        switch ( $value ) {

            case 0:
                $spacing_size = 'none';
                break;

            case 1:
                $spacing_size = 'sm';
                break;

            case 2:
                $spacing_size = 'md';
                break;

            case 3:
                $spacing_size = 'lg';
                break;

        }

        return $spacing_size ?? '';
    }

    public static function getColorChoices($colors)
    {
        if ( !empty( $colors ) ) {

            foreach ( $colors as $color ) {
                $choices[$color] = get_stylesheet_directory_uri(__FILE__) . '/resources/assets/swatches/' . $color . '.png';
            }

        }

        return $choices ?? [];
    }

    public static function getCustomClasses($custom_classes, $args)
    {
        $response = "";

        if ( !empty( $args['background_color'] ) ) {
            $response .= ( $args['background_color'] == 'black' ) ? " bg-dark bg-" . $args['background_color'] : " bg-" . $args['background_color'];
        }

        $response .= ( isset( $args['option_top_margin'] ) && $args['option_top_margin'] != 2 ) ? ' mt-' . self::setSpacingSize( $args['option_top_margin'] ) : '';
        $response .= ( isset( $args['option_bottom_margin'] ) && $args['option_bottom_margin'] != 0 ) ? ' mb-' . self::setSpacingSize( $args['option_bottom_margin'] ) : '';
        $response .= ( isset( $args['option_top_padding'] ) && $args['option_top_padding'] != 2 ) ? ' pt-' . self::setSpacingSize( $args['option_top_padding'] ) : '';
        $response .= ( isset( $args['option_bottom_padding'] ) && $args['option_bottom_padding'] != 2 ) ? ' pb-' . self::setSpacingSize( $args['option_bottom_padding'] ) : '';

        $response .= (!empty( $custom_classes )) ? " " . $custom_classes : "";
        $response .= (!empty( $args['option_html_classes'] ) ) ? " " . $args['option_html_classes'] : "";

        // Module Alignment
        if (!empty($args['option_module_alignment'])) {
            $response .= ($args['option_module_alignment'] != 'align-left') ? ' ' . $args['option_module_alignment'] : '';
        }

        return $response;
    }

    public static function getAddress( $address )
	{
        $response = '';

        if ( $address['street1'] || $address['street2'] || $address['city'] || $address['state'] || $address['zip'] ) {
            $response .= ( $address['street1'] ) ? $address['street1'] . ", " : "";
            $response .= ( $address['street2'] ) ? $address['street2'] : "";
            $response .= ( $address['city'] ) ? "<br />" . $address['city'] : "";
            $response .= ( $address['state'] ) ? ", " . $address['state'] : "";
            $response .= ( $address['zip'] ) ? " " . $address['zip'] : "";
        }

        return $response;
    }

    public static function getPhoneNumber( $phone )
	{
        $formatted = '';

        if( preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $phone['national'], $pieces ) ) {
            return $pieces[1] . '-' . $pieces[2] . '-' . $pieces[3];
        }

        return $formatted;
    }

    public static function getPageTemplateID( $page_template )
    {

        $post = get_posts( ['post_type' => 'page', 'meta_key' => '_wp_page_template', 'meta_value' => $page_template] );
        
        return $post ? array_shift( $post )->ID : '';

    }

}
