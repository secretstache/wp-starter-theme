<?php

namespace App\Fields\Templates;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Lists\Modules;
use App\Fields\Components\TemplateHeader;
use App\Fields\Options\Background;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\Admin;
use App\Fields\Options\TemplateSpacing;

class SplitContent {

	public static function getFields() {

        /**
         * [Template] - Split Content
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Link to Team Snippet Code
         */
        $splitContentTemplate = new FieldsBuilder('split-content', [
            'label'	=> 'Split Content'
        ]);

        $splitContentTemplate

            ->addTab('Content')

                ->addFields(TemplateHeader::getFields())

                ->addRepeater('items', [
                    'label'         => false,
                    'layout'	    => 'block',
                    'button_label'	=> 'Add Item',
                    'min'			=> 1,
                ])

                    ->addRadio('media_type', [
                        'label'     => 'Media Type',
                        'layout'    => 'horizontal'
                    ])
                        ->addChoice('image','Image')
                        ->addChoice('video','Video')

                    ->addImage('image', [
                        'label'         => false,
                        'preview_size'  => 'medium',
                    ])
                        ->conditional('media_type', '==', 'image')

                    ->addOembed('oembed', [
                        'label' 	=> false,
                    ])
                        ->conditional('media_type', '==', 'video')
                    
                    ->addFields(Modules::getFields( $media_modules = false ))
                    
                ->endRepeater()

            ->addTab('Options')

                ->addFields(Background::getFields())

                ->addFields(TemplateSpacing::getFields())

                ->addRadio('media_position', [
                    'label'        => 'Starting Media Position',
                    'layout'       => 'horizontal',
                    'choices'      => [
                        'left'     => 'Left',
                        'right'    => 'Right',
                    ],
                ])

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());
        
        return $splitContentTemplate;

	}

}