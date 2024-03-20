<?php

namespace App\Fields\Options;

use StoutLogic\AcfBuilder\FieldsBuilder;

class HtmlAttributes {

	public static function getFields() {

		/**
         * [Option] - HTML Attributes
         */
        $htmlAttributesOptions = new FieldsBuilder('html_attributes_options');

        $htmlAttributesOptions

            ->addText('option_html_id', [
                'label'	=> 'HTML ID'
            ])
            
            ->addText('option_html_classes', [
                'label'	=> 'HTML Classes'
            ]);

        return $htmlAttributesOptions;

	}

}