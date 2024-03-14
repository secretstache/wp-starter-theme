<?php

namespace App\Fields\Modules;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Components\Button as ButtonComponent;
use App\Fields\Options\Admin;
use App\Fields\Options\ModuleMargins;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\ModuleAlignment;

class Buttons
{

    public static function getFields()
    {

        /**
         * [Module] - Button
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Link to Team Snippet Code
         */
        $buttonModule = new FieldsBuilder('button', [
            'title'    => 'Button(s)'
        ]);

        $buttonModule

            ->addTab('Content')

                ->addRepeater('buttons', [
                    'label'        => false,
                    'layout'       => 'block', // table, block, row
                    'min'          => 1,
                    'max'          => 2,
                    'button_label' => 'Add Button',
                    'collapsed'    => 'button_label',
                ])

                    ->addFields(ButtonComponent::getFields())

                ->endRepeater()

            ->addTab('Options')

                ->addFields(ModuleMargins::getFields())

                ->addFields(ModuleAlignment::getFields())

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());

        return $buttonModule;
    }
}