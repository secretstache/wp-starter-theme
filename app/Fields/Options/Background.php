<?php

namespace App\Fields\Options;

use App\View\Composers\SSM;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Background {

	public static function getFields() {

		/**
         * [Option] - Background Options
         */
        $backgroundOptions = new FieldsBuilder('background_options');

        $backgroundOptions

            ->addRadio('option_background', [
                'label'		    => 'Background Options',
                'layout'	    => 'horizontal',
                'choices'       => [
                    'color'     => 'Color',
                    'image'     => 'Image',
                ]
            ])

            ->addField('background_color', 'acfe_image_selector', [
                'label'         => 'Background Color',
                'image_size'    => 'thumbnail',
                'choices'       => SSM::getColorChoices(['white', 'blue']),
                'wrapper'       => [
                    'class'     => 'ssm-background-color-img',
                ],
            ])
                ->conditional('option_background', '==', 'color')

            ->addImage('background_image', [
                'label'         => 'Background Image',
                'preview_size'  => 'medium',
            ])
                ->conditional('option_background', '==', 'image');

		return $backgroundOptions;

	}

}