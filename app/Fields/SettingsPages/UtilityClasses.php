<?php

namespace App\Fields\SettingsPages;

use StoutLogic\AcfBuilder\FieldsBuilder;

class UtilityClasses
{

    public function __construct()
    {

        /**
         * Utility Classes
         * 
         */
        $utilityClasses = new FieldsBuilder('utility_classes', [
            'title'         => 'Utility Classes',
            'style'         => 'seamless',
            'menu_order'    => 1
        ]);

        $utilityClasses

            ->addMessage('utility_classes_list', 'message', [
                'label'     => false,
                'message'   => ''
            ])

            ->setLocation('options_page', '==', 'acf-options-utility-classes');

        // Register Utility Classes
        add_action('acf/init', function () use ($utilityClasses) {
            acf_add_local_field_group($utilityClasses->build());
        });

        /**
         * Utility Classes - Admin  
         * 
         */
        $utilityClassesAdmin = new FieldsBuilder('utility_classes_admin', [
            'title'         => 'Utility Classes',
            'menu_order'    => 5
        ]);

        $utilityClassesAdmin

            ->addRepeater('utility_classes', [
                'label'         => false,
                'layout'        => 'block',
                'min'           => 1,
                'collapsed'     => 'name',
                'button_label'  => 'Add Utility Class',
            ])

                ->addText('name', [
                    'label'         => 'Name',
                ])

                ->addWysiwyg('description', [
                    'label'         => 'Description',
                    'toolbar'       => 'basic',
                    'media_upload'  => 0
                ])

            ->endRepeater()

            ->setLocation('options_page', '==', 'acf-options-utility-classes');

        // Register Utility Classes - Admin
        add_action('acf/init', function () use ($utilityClassesAdmin) {
            acf_add_local_field_group($utilityClassesAdmin->build());
        });
    }
}
