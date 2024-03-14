<?php

namespace App\Fields\Modules;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Options\Admin;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\ModuleAlignment;
use App\Fields\Options\ModuleMargins;

class Header {

	public static function getFields() {

		/**
         * [Module] - Header
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Link to Team Snippet Code
         */
        $headerModule = new FieldsBuilder('header', [
            'title'	=> 'Header'
        ]);

        $headerModule

            ->addTab('Content')

                ->addRepeater('headlines', [
                    'label'         => false,
                    'layout'        => 'block',
                    'min'           => 1,
                    'max'           => 3,
                    'collapsed'     => 'headline',
                    'button_label'  => 'Add Headline',
                ])

                    ->addText('headline', [
                        'label'          => 'Headline',
                    ])

                    ->addSelect('headline_tag', [
                        'label'          => 'HTML Tag',
                        'multiple'       => 0,
                        'ui'             => 0,
                        'ajax'           => 0,
                        'choices'        => [
                            'h1'         => 'H1',
                            'h2'         => 'H2',
                            'h3'         => 'H3',
                        ],
                        'default_value'  => 'h2',
                        'wrapper'        => [
                            'width'      => 50
                        ]
                    ])

                    ->addSelect('headline_display', [
                        'label'          => 'Display',
                        'multiple'       => 0,
                        'ui'             => 0,
                        'ajax'           => 0,
                        'choices'        => [
                            'default'    => 'Default',
                            'h1'         => 'Like H1',
                            'h2'         => 'Like H2',
                            'h3'         => 'Like H3',
                        ],
                        'wrapper'        => [
                            'width'      => 50
                        ]
                    ])

                ->endRepeater()

            ->addTab('Options')

                ->addFields(ModuleMargins::getFields())

                ->addFields(ModuleAlignment::getFields())

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());

		return $headerModule;

	}

}