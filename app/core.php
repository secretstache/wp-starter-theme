<?php

namespace App;

/**
 * Disable unused widgets
 * 
 */
add_action('widgets_init', function () {

    unregister_widget("WP_Widget_Pages");
    unregister_widget("WP_Widget_Calendar");
    unregister_widget("WP_Widget_Meta");
    unregister_widget("WP_Widget_Recent_Posts");
    unregister_widget("WP_Widget_Recent_Comments");
    unregister_widget("WP_Widget_RSS");
    unregister_widget("WP_Widget_Tag_Cloud");
});

/**
 * Remove default dasboards
 * 
 */
add_action('admin_init', function () {

    remove_meta_box("dashboard_right_now", "dashboard", "normal");
    remove_meta_box("dashboard_incoming_links", "dashboard", "normal");
    remove_meta_box("dashboard_plugins", "dashboard", "normal");
    remove_meta_box("dashboard_primary", "dashboard", "side");
    remove_meta_box("dashboard_secondary", "dashboard", "normal");
    remove_meta_box("dashboard_quick_press", "dashboard", "side");
    remove_meta_box("dashboard_recent_drafts", "dashboard", "side");
    remove_meta_box("dashboard_recent_comments", "dashboard", "normal");
    remove_meta_box("dashboard_activity", "dashboard", "normal");
    remove_meta_box("rg_forms_dashboard", "dashboard", "normal");
    remove_meta_box("wpe_dify_news_feed", "dashboard", "normal");
    remove_meta_box("wpseo-dashboard-overview", "dashboard", "normal");
    remove_meta_box("ssm_main_dashboard_widget", "dashboard", "normal");
    remove_meta_box("wpseo-wincher-dashboard-overview", "dashboard", "normal");
    remove_action("try_gutenberg_panel", "wp_try_gutenberg_panel");
});

add_action('login_enqueue_scripts', function () {

    $background_image = ($background_image_id = get_option('options_login_logo')) ? wp_get_attachment_url($background_image_id) : SSM_CORE_URL . "assets/images/login-logo.png";

    if ($GLOBALS["pagenow"] === "wp-login.php") :
        ?>
            <style type="text/css">
                body.login div#login h1 a {
                    background-image: url(<?php echo $background_image; ?>) !important;
                    background-repeat: no-repeat;
                    background-size: contain;
                    width: auto;
                    height: 90px;
                    margin-bottom: 15px;
                }
            </style>
        <?php
    endif;
});

/**
 * Makes the login screen"s logo link to your homepage, instead of to WordPress.org
 * 
 */
add_filter('login_headerurl', function ($login_header_url) {
    return home_url();
});

/**
 * Makes the login screen's logo title attribute your site title, instead of "Powered by WordPress".
 * 
 */
add_filter('login_headertext', function ($login_header_text) {
    return get_bloginfo("name");
});

/**
 * Makes WordPress-generated emails appear "from" your WordPress site name, instead of from "WordPress"
 * 
 */
add_filter('wp_mail_from_name', function ($from_name) {
    return get_option("blogname");
});

/**
 * Makes WordPress-generated emails appear "from" your WordPress admin email address
 * 
 */
add_filter('wp_mail_from', function ($from_email) {
    return get_option("admin_email");
});

/**
 * Removes the WP icon from the admin bar
 * 
 */
add_action('wp_before_admin_bar_render', function () {

    global $wp_admin_bar;

    $wp_admin_bar->remove_menu("wp-logo");
});

/**
 * Modify the admin footer text
 *
 */
add_filter('admin_footer_text', function ($text) {

    $agency_name = get_option('options_agency_name') ?: 'Secret Stache Media';
    $agency_url = get_option('options_agency_url') ?: 'https://www.secretstache.com/';

    return 'Built by <a href="' . $agency_url . '" target="_blank">' . $agency_name . '</a> with WordPress.';
}, 99);

/**
 * Add Development Links widget
 *
 */
add_action('wp_dashboard_setup', function () {

    $development_team = get_option('options_development_team');
    $current_user = wp_get_current_user();

    if (is_array($development_team) && in_array($current_user->data->ID, $development_team)) {
        wp_add_dashboard_widget('development_links', 'Development Links', __NAMESPACE__ . '\\developmentLinksWidgetCB');
    }

    function developmentLinksWidgetCB($post, $callback_args)
    {

        $response = '';

        $response .= '<a href="' . admin_url('plugins.php') . '">Plugins</a>';

        $response .= ' | ' . '<a href="' . admin_url('options-general.php?page=acf-options-core') . '">Core Settings</a>';
        $response .= ' | ' . '<a href="' . admin_url('options-general.php?page=menu_editor') . '">Menu Editor Pro</a>';
        $response .= ' | ' . '<a href="' . admin_url('tools.php?page=wp-migrate-db-pro') . '">Migrate DB Pro</a>';

        echo $response;
    }
});

/**
 * Enqueue Core scripts
 *
 */
if( class_exists('acf') ) {

    add_action('wp_head', function () {

        if (is_user_logged_in()) {

            if (($core_scripts = get_field('core_scripts', 'options')) && !empty($core_scripts)) {

                foreach ($core_scripts as $core_script) {

                    if (in_array('public', $core_script['locations']) && $core_script['script']) {
                        echo $core_script['script'];
                    }
                }
            }
        }
    }, 99);

    add_action('admin_head', function () {

        if (is_user_logged_in()) {

            if (($core_scripts = get_field('core_scripts', 'options')) && !empty($core_scripts)) {

                foreach ($core_scripts as $core_script) {

                    if (in_array('admin', $core_script['locations']) && $core_script['script']) {
                        echo $core_script['script'];
                    }
                }
            }
        }
    }, 99);

    /**
     * Load Available Dashboard Widgets into the ACF Field
     */
    add_filter('acf/load_field/name=dashboard_widgets_to_remove', function ($field) {
        $field['choices'] = get_option('all_dashboard_widgets') ?? [];
        return $field;
    });

    /**
     * Setup the Dashboard Widgets
     */
    add_action('wp_dashboard_setup', function () {
        $widgets_to_remove = get_field('dashboard_widgets_to_remove', 'options');

        update_option('all_dashboard_widgets', get_all_dashboard_widgets());
        remove_dashboard_widgets($widgets_to_remove);
    }, 999);

    /**
     * Retrieve All Dashboard Widgets With Their Titles
     */
    function get_all_dashboard_widgets()
    {
        global $wp_meta_boxes;

        if (!empty($wp_meta_boxes['dashboard'])) {
            foreach ($wp_meta_boxes['dashboard'] as $context => $priorities) {
                foreach ($priorities as $priority => $widgets_by_priority) {
                    foreach ($widgets_by_priority as $widget_id => $widget) {
                        if (isset($widget['title'])) {
                            $widgets[$widget_id] = $widget['title'];
                        }
                    }
                }
            }
        }

        return $widgets ?? [];
    }

    /**
     * Remove Specified Widgets From the Dashboard
     */
    function remove_dashboard_widgets($widgets_to_remove)
    {
        global $wp_meta_boxes;

        if (empty($widgets_to_remove)) {
            return;
        }

        foreach ($widgets_to_remove as $widget_id) {
            foreach ($wp_meta_boxes['dashboard'] as &$priorities) {
                foreach ($priorities as $priority => &$widgets) {
                    if (isset($widgets[$widget_id])) {
                        unset($widgets[$widget_id]);
                    }
                }
            }
        }
    }

}

/**
 * Create Sample Post Containing Default Editor Elements
 */
add_action('after_switch_theme', function () {

    if (defined('SSM_ENVIRONMENT') && in_array(SSM_ENVIRONMENT, ['Staging', 'Development']) && get_option('activated_sample_post') !== 'yes') {

        $post_content = '<h1>H1 Heading</h1>
            <p>This is a sample paragraph with an <a target="_blank" href="/">inline link</a>.</p>
            <img class="size-full aligncenter" src="' . esc_url(get_template_directory_uri() . '/resources/images/cms/placeholder.svg') . '" alt="Placeholder Image" />
            
            <h2>H2 Heading</h2>
            <blockquote>This is a sample blockquote - Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</blockquote>
            
            <h3>H3 Heading</h3>
            <p>Here is a Unordered List:</p>
            <ul>
                <li>Unordered List Item 1</li>
                <li>Unordered List Item 2</li>
                <li>Unordered List Item 3</li>
            </ul>

            <h4>H4 Heading</h4>
            <p>Here is an Ordered List:</p>
            <ol>
                <li>Ordered List Item 1</li>
                <li>Ordered List Item 2</li>
                <li>Ordered List Item 3</li>
            </ol>

            <h5>H5 Heading</h5>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            <figure class="wp-caption aligncenter">
                <img class="size-full" src="' . esc_url(get_template_directory_uri() . '/resources/images/cms/placeholder.svg') . '" alt="Placeholder Image" />
                <figcaption class="wp-caption-text">This is a caption for the image</figcaption>
            </figure>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

            <h6>H6 Heading</h6>
            <figure class="wp-caption alignleft">
                <img class="size-full" src="' . esc_url(get_template_directory_uri() . '/resources/images/cms/placeholder.svg') . '" alt="Placeholder Image" />
                <figcaption class="wp-caption-text">This is a caption for the image</figcaption>
            </figure>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            <img class="size-full alignright" src="' . esc_url(get_template_directory_uri() . '/resources/images/cms/placeholder.svg') . '" alt="Placeholder Image" />
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            
            <h6>H6 Heading</h6>
            <figure class="wp-caption alignleft">
                <img class="size-full" src="' . esc_url(get_template_directory_uri() . '/resources/images/cms/placeholder.svg') . '" alt="Placeholder Image" />
                <figcaption class="wp-caption-text">This is a caption for the image</figcaption>
            </figure>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            
            <h3>Here is an embedded YouTube video:</h3>
            [embed]https://www.youtube.com/watch?v=dQw4w9WgXcQ[/embed]
            <h3>Here is a Gravity Form shortcode:</h3>
            [gravityform id="1" title="false" description="false"]
        ';

        $post_data = [
            'post_title'    => 'Sample Post',
            'post_content'  => $post_content,
            'post_status'   => 'publish',
            'post_type'     => 'post',
            'post_author'   => 1,
        ];

        wp_insert_post($post_data); update_option('activated_sample_post', 'yes');
    }
});