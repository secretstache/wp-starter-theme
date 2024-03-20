<?php

namespace App\Fields\Modules;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Components\Form as FormComponent;
use App\Fields\Options\Admin;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\ModuleMargins;

class Form {

	public static function getFields() {

		/**
         * [Module] - Form
         */
        $formModule = new FieldsBuilder('form', [
            'title'	=> 'Form'
        ]);

        $formModule

            ->addTab('Content')

                ->addFields(FormComponent::getFields())

            ->addTab('Options')

                ->addFields(ModuleMargins::getFields())

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());

		return $formModule;

	}

}