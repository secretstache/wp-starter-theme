<?php

namespace App\Fields\Options;

use StoutLogic\AcfBuilder\FieldsBuilder;

class ModuleMargins
{

    public static function getFields()
    {

        /**
         * [Option] - Module Margins Options
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Link to Team Snippet Code
         */
        $moduleMarginsOptions = new FieldsBuilder('module_margins_options');

        $moduleMarginsOptions

            ->addField('option_top_margin', 'range', [
                'label'         => 'Top Margin',
                'default_value' => 2,
                'min'           => 0,
                'max'           => 3,
                'step'          => 1,
                'wrapper'       => [
                    'width'     => 50
                ]
            ])

            ->addField('option_bottom_margin', 'range', [
                'label'         => 'Bottom Margin',
                'default_value' => 0,
                'min'           => 0,
                'max'           => 3,
                'step'          => 1,
                'wrapper'       => [
                    'width'     => 50
                ]
            ]);

        return $moduleMarginsOptions;
    }
}