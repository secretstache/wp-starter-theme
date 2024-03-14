<?php

namespace App\Fields\Options;

use StoutLogic\AcfBuilder\FieldsBuilder;

class ImageLink {

	public static function getFields() {

		/**
         * [Option] - Image Link
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Extract Link Source into it's own snippet
         * @todo Link to Team Snippet Code
         */
        $imageLinkOptions = new FieldsBuilder('image_link_options');

        $imageLinkOptions

            ->addTrueFalse('include_image_link', [
                'label'         => false,
                'message'		=> 'Add Image Link',
            ])

            ->addRadio('link_source', [
                'label'			=> 'Source',
                'layout'		=> 'horizontal',
                'wrapper'		=> [
                    'width'		=> '50'
                ],
                'choices'       => [
                    'internal'  => 'Internal Page',
                    'external'  => 'External URL',
                ]
            ])
            ->conditional('include_image_link', '==', 1)

            ->addPostObject('link_page_id', [
                'label'			=> 'Select Page',
                'post_type'     => ['page'],
                'wrapper'		=> [
                    'width'		=> 50
                ]	
            ])
                ->conditional('link_source', '==', 'internal')

            ->addText('link_url', [
                'label'			=> 'URL',
                'wrapper'		=> [
                    'width'		=> 50
                ]	
            ])
                ->conditional('link_source', '==', 'external');

		return $imageLinkOptions;

	}

}