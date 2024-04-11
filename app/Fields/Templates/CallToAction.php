<?php

namespace App\Fields\Templates;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Components\Button;
use App\Fields\Options\Background;
use App\Fields\Options\TemplateSpacing;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\Admin;

class CallToAction
{

    public static function getFields()
    {

        /**
         * [Template] - Call to Action
         */
        $callToActionTemplate = new FieldsBuilder('call-to-action', [
            'title'    => 'Call to Action'
        ]);

        $callToActionTemplate

            ->addTab('Content')

                ->addText('headline', [
                    'label'         => 'Headline',
                ])

                ->addTextarea('desc', [
                    'label'         => 'Short Description',
                    'rows'          => '2'
                ])

                ->addTrueFalse('include_button', [
                    'label'         => false,
                    'message'       => 'Include Button',
                    'default_value' => 0,
                ])

                ->addGroup('button', [
                    'label'         => false,
                ])
                ->conditional('include_button', '==', 1)

                    ->addFields(Button::getFields())

                ->endGroup()

            ->addTab('Options')

                ->addFields(Background::getFields())

                ->addFields(TemplateSpacing::getFields())

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());

        return $callToActionTemplate;
    }
}
