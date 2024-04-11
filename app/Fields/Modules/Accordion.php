<?php

namespace App\Fields\Modules;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Options\Admin;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\ModuleMargins;

class Accordion {

	public static function getFields() {

		/**
         * [Module] - Accordion
         */
        $accordionModule = new FieldsBuilder('accordion', [
            'title'	=>	'Accordion'
        ]);

        $accordionModule

            ->addTab('Content')

                ->addRepeater('items', [
                    'label'        => false,
                    'layout'       => 'block',
                    'min'          => 1,
                    'collapsed'    => 'title',
                    'button_label' => 'Add Item',
                ])

                    ->addText('title', [
                        'label'         => 'Title',
                    ])

                    ->addWysiwyg('desc', [
                        'label'         => 'Description',
                        'toolbar'       => 'basic',
                        'media_upload'  => 0
                    ])

                ->endRepeater()

            ->addTab('Options')

                ->addFields(ModuleMargins::getFields())
            
                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());
        
		return $accordionModule;

	}

}