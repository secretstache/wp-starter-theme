<?php

namespace App\Fields\Objects;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Lists\Modules;

class ModuleTemplate {

	public function __construct() {

		/**
		 * Modules Templates
		 */

		$modulesTemplate = new FieldsBuilder('modules-template', [
			'style'         => 'seamless',
            'position'      => 'normal',
            'menu_order'    => 4,
        ]);

        $modulesTemplate

            ->addFields(Modules::getFields())

			->setLocation('post_type', '==', 'mb_template');

		// Register Modules Template
		add_action('acf/init', function() use ($modulesTemplate) {
			acf_add_local_field_group($modulesTemplate->build());
		});

	}

}