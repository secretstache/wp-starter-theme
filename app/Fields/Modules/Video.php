<?php

namespace App\Fields\Modules;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Options\Admin;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\ModuleMargins;

class Video {

	public static function getFields() {

		/**
         * [Module] - Video
         */
        $videoModule = new FieldsBuilder('video', [
            'title'	=> 'Video'
        ]);

        $videoModule

            ->addTab('Content')

                ->addRadio('type', [
                    'label'        => 'Type',
                    'layout'       => 'horizontal',
                    'choices'      => [
                        'oembed'   => 'oEmbed',
                        'external' => 'External File',
                    ],
                ])

                ->addOembed('video_oembed', [
                    'label'        => false,
                ])
                ->conditional('type', '==', 'oembed')

                ->addImage('fallback_image', [
                    'label'        => 'Fallback Image',
                    'preview_size' => 'medium', // thumbnail, medium, large
                ])
                ->conditional('type', '==', 'external')

                ->addText('video_url', [
                    'label'     => false,
                    'prepend'   => 'Video URL'
                ])
                ->conditional('type', '==', 'external')

            ->addTab('Options')

                ->addFields(ModuleMargins::getFields())

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());
                
		return $videoModule;

	}

}