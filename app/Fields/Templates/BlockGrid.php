<?php

namespace App\Fields\Templates;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Components\TemplateHeader;
use App\Fields\Components\Button;
use App\Fields\Options\Background;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\Admin;
use App\Fields\Options\TemplateSpacing;

class BlockGrid {

	public static function getFields() {

        /**
         * [Template] - Block Grid
         */
        $blockGridTemplate = new FieldsBuilder('block-grid', [
            'label'	=> 'Block Grid'
        ]);

        $blockGridTemplate

            ->addTab('Content')

                ->addFields(TemplateHeader::getFields())

                ->addRepeater('grid_items', [
                    'label'         => false,
                    'layout'	    => 'block',
                    'button_label'	=> 'Add Item',
                    'min'			=> 1,
                    'collapsed'	    => 'title',
                ])

                    ->addImage('icon', [
                        'label'	    => 'Icon'
                    ])

                    ->addText('title', [
                        'label'	    => 'Title'
                    ])

                    ->addWysiwyg('editor', [
                        'label'        => 'Description',
                        'toolbar'      => 'basic', // basic, full
                        'media_upload' => '0', // 0, 1
                    ])

                    ->addTrueFalse('include_button', [
                        'label'         => false,
                        'message'       => 'Include Button',
                        'default_value' => 0,
                    ])

                    ->addGroup('button', [
                        'label'        => 'Button',
                    ])
                        ->conditional('include_button', '==', 1)
                    
                        ->addFields(Button::getFields())

                    ->endGroup()

                ->endRepeater()

            ->addTab('Options')

                ->addFields(Background::getFields())

                ->addFields(TemplateSpacing::getFields())

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')
            
                ->addFields(Admin::getFields());
        
        return $blockGridTemplate;

	}

}