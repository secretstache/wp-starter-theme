<?php

namespace App\Fields\Options;

use StoutLogic\AcfBuilder\FieldsBuilder;

class ContainerLayout
{

    public static function getFields()
    {

        /**
         * [Option] - Container Layout Options
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Link to Team Snippet Code
         */
        $containerLayoutOptions = new FieldsBuilder('container_layout_options');

        $containerLayoutOptions

            ->addGroup('container_options', [
                'label'        => 'Container',
            ])

            ->addField('width', 'range', [
                'label'         => 'Width',
                'default_value' => 10,
                'min'           => 1,
                'max'           => 12,
                'step'          => 1,
                'wrapper'       => [
                    'width'     => 50
                ]
            ])

            ->addSelect('alignment_x', [
                'label'         => 'Horizontal Alignment',
                'multiple'      => 0,
                'ui'            => 0,
                'ajax'          => 0,
                'choices'       => [
                    'left'      => 'Left',
                    'center'    => 'Center',
                    'right'     => 'Right',
                ],
                'wrapper'       => [
                    'width'     => 50
                ],
                'default_value' => 'center'
            ])

            ->endGroup();

        return $containerLayoutOptions;
    }
}