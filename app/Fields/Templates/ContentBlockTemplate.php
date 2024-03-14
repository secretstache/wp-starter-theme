<?php

namespace App\Fields\Templates;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Options\Admin;

class ContentBlockTemplate {

	public static function getFields() {

        /**
         * [Template] - Content Block Template
         */
        $contentBlockTemplate = new FieldsBuilder('content-block-template', [
            'label'	=> 'Content Block Template'
        ]);

        $contentBlockTemplate

            ->addTab('Content')

                ->addPostObject('template_id', [
                    'label'		 => 'Select a Template',
                    'post_type'  => ['cb_template'],
                    'allow_null' => 1,
                ])

                ->addField('cb_template_message', 'message', [
                    'label'     => false,
                    'message'   => 'Edit or add new Content Block Templates <a target="_blank" href="'. admin_url('edit.php?post_type=cb_template') .'">here.</a>',
                ])

            ->addTab('Admin')

                ->addFields(Admin::getFields());

        return $contentBlockTemplate;

	}

} 