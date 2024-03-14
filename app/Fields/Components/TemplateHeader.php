<?php

namespace App\Fields\Components;

use StoutLogic\AcfBuilder\FieldsBuilder;

class TemplateHeader {

	public static function getFields() {

		/**
         * [Option] - Template Header
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Extract Headline / Subheadline into a Header Snippet
         * @todo Link to Team Snippet Code
         */
        $templateHeaderOptions = new FieldsBuilder('template-header');

        $templateHeaderOptions

            ->addTrueFalse('include_template_header', [
                'label'         => false,
                'message'       => 'Include Template Header',
            ])

            ->addRadio('template_alignment', [
                'label'         => 'Alignment',
                'layout'        => 'horizontal',
                'choices'       => [
                    'left'      => 'Left',
                    'center'    => 'Center',
                ],
                'default_value' => 'center'
            ])
            ->conditional('include_template_header', '==', 1)

            ->addText('template_preheadline', [
                'label'         => 'Pre-Headline'
            ])
            ->conditional('include_template_header', '==', 1)

            ->addText('template_headline', [
                'label'         => 'Headline',
                'wrapper'       => [
                    'width'     => 70
                ]
            ])
            ->conditional('include_template_header', '==', 1)

            ->addSelect('template_headline_tag', [
                'label'         => 'HTML Tag',
                'multiple'      => 0,
                'ui'            => 0,
                'ajax'          => 0,
                'choices'       => [
                    'h1'        => 'H1',
                    'h2'        => 'H2',
                    'h3'        => 'H3',
                    'h4'        => 'H4',
                    'h5'        => 'H5',
                ],
                'default_value' => 'h2',
                'wrapper'       => [
                    'width'     => 15
                ]
            ])
            ->conditional('include_template_header', '==', 1)

            ->addSelect('template_headline_display', [
                'label'         => 'Display',
                'multiple'      => 0,
                'ui'            => 0,
                'ajax'          => 0,
                'choices'       => [
                    'default'   => 'Default',
                    'h1'        => 'Like H1',
                    'h2'        => 'Like H2',
                    'h3'        => 'Like H3',
                    'h4'        => 'Like H4',
                    'h5'        => 'Like H5',
                ],
                'wrapper'       => [
                    'width'     => 15
                ]
            ])
            ->conditional('include_template_header', '==', 1)

            ->addText('template_subheadline', [
                'label'         => 'Subheadline',
            ])
            ->conditional('include_template_header', '==', 1);

		return $templateHeaderOptions;

	}

}