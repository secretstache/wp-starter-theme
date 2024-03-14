<?php

namespace App\Fields\Options;

use StoutLogic\AcfBuilder\FieldsBuilder;

class ModuleAlignment {

	public static function getFields() {

		/**
         * [Option] - Module Alignment
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Link to Team Snippet Code
         */
        $moduleAlignmentOptions = new FieldsBuilder('default_module_alignment');
        
        $moduleAlignmentOptions

            ->addRadio('option_module_alignment', [
                'label'            => 'Alignment',
                'layout'           => 'horizontal',
                'choices'          => [
                    'align-left'   => 'Left',
                    'align-center' => 'Center',
                    'align-right'  => 'Right',
                ],
            ]);

		return $moduleAlignmentOptions;

	}

}