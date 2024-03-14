<?php

namespace App\Fields\Templates;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Lists\Modules;
use App\Fields\Components\TemplateHeader;
use App\Fields\Options\Background;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\Admin;
use App\Fields\Options\ContainerLayout;
use App\Fields\Options\TemplateSpacing;

class Columns 
{

	public static function getFields() 
    {

        /**
         * [Template] - Free Form
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Link to Team Snippet Code
         */
        $columnsTemplate = new FieldsBuilder('columns', [
            'title'	=> 'Free Form'
        ]);

        $columnsTemplate

            ->addTab('Content')

                ->addFields(TemplateHeader::getFields())

                ->addRepeater('columns', [
                    'label'         => false,
                    'layout'		=> 'block',
                    'min'			=> 1,
                    'max'			=> 2,
                    'button_label'	=> 'Add Column',
                ])

                    ->addTab('Content', [
                        'placement'	=>	'left'
                    ])

                        ->addFields(Modules::getFields())

                    ->addTab('Options')

                        ->addFields(HtmlAttributes::getFields())

                ->endRepeater()

            ->addTab('Options')

                ->addFields(Background::getFields())

                ->addFields(TemplateSpacing::getFields())

                ->addFields(ContainerLayout::getFields())

                ->addGroup('two_column_layout', [
                    'label' => '2 Columns'
                ])
                    ->conditional('columns', '>', 1)

                    ->addField('left_column_width', 'range', [
                        'label'         => 'Left Column',
                        'default_value' => 6,
                        'min'           => 1,
                        'max'           => 11,
                        'step'          => 1,
                        'wrapper'       => [
                            'width'     => 25
                        ]
                    ])

                    ->addField('right_column_width', 'range', [
                        'label'         => 'Right Column',
                        'default_value' => 6,
                        'min'           => 1,
                        'max'           => 11,
                        'step'          => 1,
                        'wrapper'       => [
                            'width'     => 25
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
                            'justify'   => 'Justify',
                        ],
                        'wrapper'       => [
                            'width'     => 25
                        ],
                        'default_value' => 'center'
                    ])

                    ->addSelect('alignment_y', [
                        'label'         => 'Vertical Alignment',
                        'multiple'      => 0,
                        'ui'            => 0,
                        'ajax'          => 0,
                        'choices'       => [
                            'top'       => 'Top',
                            'middle'    => 'Middle',
                            'bottom'    => 'Bottom',
                            'stretch'   => 'Stretch',
                        ],
                        'wrapper'       => [
                            'width'     => 25
                        ],
                        'default_value' => 'middle'
                    ])

                ->endGroup()

                ->addField('option_columns_mobile_order', "text", [
                    'label'        => 'Mobile Order',
                    'wrapper'      => [
                        'class'    => 'column-layout-mobile-order'
                    ]
                ])
                ->conditional('columns', '>', 1)

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());
            
        return $columnsTemplate;
	}
}