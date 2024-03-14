<?php

namespace App\Fields\Templates;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Components\TemplateHeader;
use App\Fields\Components\Gallery as GalleryComponent;
use App\Fields\Options\Background;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\Admin;
use App\Fields\Options\TemplateSpacing;

class Gallery {

	public static function getFields() {

        /**
         * [Template] - Gallery
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Link to Team Snippet Code
         */
        $galleryTemplate = new FieldsBuilder('gallery', [
            'label'	=> 'Image Gallery'
        ]);

        $galleryTemplate

            ->addTab('Content')

                ->addFields(TemplateHeader::getFields())
                
                ->addFields(GalleryComponent::getFields())

            ->addTab('Options')

                ->addFields(Background::getFields())

                ->addFields(TemplateSpacing::getFields())

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());
        
        return $galleryTemplate;

	}

}