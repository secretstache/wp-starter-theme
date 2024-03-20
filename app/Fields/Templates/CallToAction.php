<?php

namespace App\Fields\Templates;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Components\Header;
use App\Fields\Components\Button;
use App\Fields\Options\Background;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\Admin;
use App\Fields\Options\TemplateSpacing;

class CallToAction {

	public static function getFields() {

		/**
         * [Template] - Call to Action
         */
        $callToActionTemplate = new FieldsBuilder('call-to-action', [
            'title'	=> 'Call to Action'
        ]);

        $callToActionTemplate

            ->addTab('Content')

                ->addFields(Header::getFields())

                ->addFields(Button::getFields())

            ->addTab('Options')

                ->addFields(Background::getFields())

                ->addFields(TemplateSpacing::getFields())

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());
        
        return $callToActionTemplate;

	}

}