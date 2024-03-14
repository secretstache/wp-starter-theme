<?php

namespace App\Fields\Modules;

use StoutLogic\AcfBuilder\FieldsBuilder;

class ModuleTemplate {

	public static function getFields() {

        /**
         * [Template] - Module Template
         */
        $moduleTemplate = new FieldsBuilder('module-template', [
            'label'	=> 'Module Template'
        ]);

        $moduleTemplate

            ->addPostObject('module_id', [
                'label'		    => 'Select a Module',
                'post_type'     => ['mb_template'],
                'allow_null'    => 1,
            ])

            ->addField('mb_template_message', 'message', [
                'label'     => false,
                'message'   => 'Edit or add new Module Templates <a target="_blank" href="'. admin_url('edit.php?post_type=mb_template') .'">here.</a>',
            ]);

        return $moduleTemplate;

	}

} 