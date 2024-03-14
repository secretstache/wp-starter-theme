<?php

namespace App\Fields\Options;

use StoutLogic\AcfBuilder\FieldsBuilder;

class Admin {

	public static function getFields() {

        /**
         * [Option] - Admin Options
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Link to Team Code Snippet
         */
        $adminOptions = new FieldsBuilder('admin_options');

        $adminOptions

            ->addText('option_section_label', [
                'label'			=> 'Admin Label',
                'instructions' 	=> 'Use this text field to override the template name that is shown on this metabox',
            ])

            ->addTrueFalse('option_status', [
                'label'			=> 'Status',
                'instructions' 	=> 'Set to inactive to remove from the frontend without deleting from the Database',
                'ui'			=> 1,
                'default_value' => 1,
                'ui_on_text' 	=> 'Active',
                'ui_off_text' 	=> 'Inactive',
            ]);

		return $adminOptions;

	}

}