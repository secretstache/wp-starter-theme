<?php

namespace App\Fields\Options;

use StoutLogic\AcfBuilder\FieldsBuilder;

class HtmlAttributes {

	public static function getFields() {

		/**
         * [Option] - HTML Attributes
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Link to Team Snippet Code
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