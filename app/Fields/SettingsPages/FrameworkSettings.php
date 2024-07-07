<?php

namespace App\Fields\SettingsPages;

use StoutLogic\AcfBuilder\FieldsBuilder;

class FrameworkSettings {

    public $default_plugins;
	public $required_plugins;

	public function __construct() {

        $this->default_plugins = [
			'action-scheduler'				=> 'Action Scheduler',
			'admin-menu-editor-pro'			=> 'Admin Menu Editor Pro',
            'advanced-custom-fields-pro' 	=> 'Advanced Custom Fields PRO',
            'acf-extended-pro' 				=> 'Advanced Custom Fields: Extended PRO',
            'acf-get-nav-menus'             => 'Advanced Custom Fields: Get nav menus',
            'better-search-replace'         => 'Better Search Replace',
            'classic-editor'				=> 'Classic Editor',
            'customizer-remove-all-parts'	=> 'Customizer Remove All Parts',
            'disable-comments'				=> 'Disable Comments',
            'facetwp'                       => 'FacetWP',
            'image-processing-queue'        => 'Image Processing Queue',
			'real-media-library'			=> 'Real Media Library',
			'safe-svg'                      => 'Safe SVG',
			'searchwp4'                     => 'SearchWP',
            'roots-soil'                    => 'Soil',
            'userswitcher'                  => 'User Switcher',
            'query-monitor'                 => 'Query Monitor',
            'wp-migrate-db-pro'             => 'WP Migrate DB Pro',
			'wp-rocket'                     => 'WP Rocket'
        ];

		$this->required_plugins = [
			'advanced-custom-fields-pro', 
			'acf-extended-pro',
			'classic-editor',
			'customizer-remove-all-parts',
			'disable-comments',
			'image-processing-queue',
			'safe-svg',
			'roots-soil'
		];

        /**
		 * Required Plugins
		 * 
		 */
		$requiredPlugins = new FieldsBuilder('required-plugins', [
			'title'			=> 'Required Plugins',
			'menu_order'	=>	10
		]);

		$requiredPlugins

			->addCheckbox('default_plugins', [
                'label'         => 'Default Plugins',
                'choices'       => $this->default_plugins,
				'default_value'	=> $this->required_plugins,
				'disabled'		=> $this->required_plugins
            ])

            ->addGroup('form_plugin', [
				'label'		=> 'Forms',
				'wrapper'	=> [
                    'width'	=> 50
                ]
			])

				->addRadio('plugin_name', [
					'label'        => false,
					'layout'       => 'horizontal',
					'choices'      => [
						'gravityforms'	=> 'Gravity Forms',
						'hubspotforms'	=> 'Hubspot Forms',
						'both'			=> 'Both',
					],
				])

			->endGroup()

			->addGroup('seo_plugin', [
				'label'		=> 'SEO',
				'wrapper'	=> [
                    'width'	=> 50
                ]
			])

				->addRadio('plugin_name', [
					'label'        => false,
					'layout'       => 'horizontal',
					'choices'      => [
						'wordpress-seo'		=> 'Yoast SEO',
						'seo-by-rank-math'	=> 'Rank Math SEO'
					]
				])

			->endGroup()

			->addRepeater('custom_plugins', [
				'label'			=> 'Custom Plugins',
				'layout'		=> 'block',
				'button_label'	=> 'Add Plugin'
			])

				->addTrueFalse('is_required', [
					'label'     => false,
					'ui'		=> 1,
					'ui_on_text' => 'Required',
					'ui_off_text' => 'Not Required',
				])

				->addRadio('source', [
					'label'        => 'Source',
					'layout'       => 'horizontal',
					'choices'      => [
						'wordpress' => 'WordPress Plugin Directory',
						'external' => 'External URL',
					]
				])

				->addText('name', [
					'label' 	=> 'Name',
					'required'	=> 1,
					'wrapper'	=> [
						'width'	=> 50
					]
				])

				->addText('slug', [
					'label' 	=> 'Slug',
					'required'	=> 1,
					'wrapper'	=> [
						'width'	=> 50
					]
				])

				->addText('external_url', [
					'label' 	=> 'External URL'
				])
					->conditional('source', '==',  'external')

				->addTextarea('description', [
					'label' 		=> 'Description',
					'instructions'	=> '<i>Optional</i>',
					'rows'			=> 2
				])
				
			->endRepeater()

            ->setLocation('options_page', '==', 'acf-options-framework-settings');

		// Register Agency Info
		add_action('acf/init', function() use ($requiredPlugins) {
			acf_add_local_field_group($requiredPlugins->build());
		});


	}

}