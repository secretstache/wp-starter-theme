<?php

namespace App\Fields\Modules;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Components\Accordion as AccordionComponent;
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

                ->addFields(AccordionComponent::getFields())

            ->addTab('Options')

                ->addFields(ModuleMargins::getFields())
            
                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());
        
		return $accordionModule;

	}

}