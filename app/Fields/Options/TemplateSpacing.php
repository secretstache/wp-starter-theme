<?php

namespace App\Fields\Options;

use StoutLogic\AcfBuilder\FieldsBuilder;

class TemplateSpacing
{

    public static function getFields()
    {

        /**
         * [Option] - Template Spacing Options
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Link to Team Snippet Code
         */
        $templateSpacingOptions = new FieldsBuilder('template_spacing_options');

        $templateSpacingOptions

            ->addField('option_top_margin', 'range', [
                'label'         => 'Top Margin',
                'default_value' => 2,
                'min'           => 0,
                'max'           => 3,
                'step'          => 1,
                'wrapper'       => [
                    'width'     => 25
                ]
            ])

            ->addField('option_bottom_margin', 'range', [
                'label'         => 'Bottom Margin',
                'default_value' => 0,
                'min'           => 0,
                'max'           => 3,
                'step'          => 1,
                'wrapper'       => [
                    'width'     => 25
                ]
            ])

            ->addField('option_top_padding', 'range', [
                'label'         => 'Top Padding',
                'default_value' => 2,
                'min'           => 0,
                'max'           => 3,
                'step'          => 1,
                'wrapper'       => [
                    'width'     => 25
                ]
            ])

            ->addField('option_bottom_padding', 'range', [
                'label'         => 'Bottom Padding',
                'default_value' => 2,
                'min'           => 0,
                'max'           => 3,
                'step'          => 1,
                'wrapper'       => [
                    'width'     => 25
                ]
            ]);

        return $templateSpacingOptions;
    }
}