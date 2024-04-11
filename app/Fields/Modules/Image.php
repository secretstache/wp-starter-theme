<?php

namespace App\Fields\Modules;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Options\Admin;
use App\Fields\Options\ImageLink;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\ModuleMargins;

class Image {

	public static function getFields() {

		/**
         * [Module] - Image
         */
        $imageModule = new FieldsBuilder('image', [
            'title'	=> 'Image'
        ]);

        $imageModule

            ->addTab('Content')

                ->addImage('image', [
                    'label'        => 'Upload Image',
                    'preview_size' => 'large',
                ])

            ->addTab('Options')

                ->addFields(ModuleMargins::getFields())

                ->addFields(ImageLink::getFields())

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());
                
		return $imageModule;

	}

}