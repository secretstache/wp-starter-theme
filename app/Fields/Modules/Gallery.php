<?php

namespace App\Fields\Modules;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Options\Admin;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\ModuleMargins;

class Gallery {

	public static function getFields() {

		/**
         * [Module] - Gallery
         */
        $galleryModule = new FieldsBuilder('gallery', [
            'title'	=>	'Gallery'
        ]);

        $galleryModule

            ->addTab('Content')

                ->addGallery('gallery', [
                    'label'    => false
                ])
                
            ->addTab('Options')

                ->addFields(ModuleMargins::getFields())
            
                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());

		return $galleryModule;

	}

}