<?php

namespace App\Fields\Lists;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Modules\Header;
use App\Fields\Modules\TextEditor;
use App\Fields\Modules\Buttons;
use App\Fields\Modules\Image;
use App\Fields\Modules\Video;
use App\Fields\Modules\Form;
use App\Fields\Modules\Gallery;
use App\Fields\Modules\Accordion;
use App\Fields\Modules\Html;
use App\Fields\Modules\ModuleTemplate;

class Modules {

	public static function getFields( $media_modules = true ) {

		/**
         * [List] - Modules
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Link to Team Snippet Code
         */
        $modulesList = new FieldsBuilder('modules_list');

        if ( $media_modules ) {

            $modulesList

                ->addFlexibleContent('modules', [
                    'acfe_flexible_advanced' 	=> 1,
                    'acfe_flexible_add_actions' => ['copy'],
                    'acfe_flexible_async' 		=> ['layout'],
                ])

                    ->addLayout(Header::getFields())

                    ->addLayout(TextEditor::getFields())

                    ->addLayout(Buttons::getFields())

                    ->addLayout(Image::getFields())

                    ->addLayout(Video::getFields())

                    ->addLayout(Form::getFields())

                    ->addLayout(Accordion::getFields())

                    ->addLayout(Html::getFields())

                    ->addLayout(ModuleTemplate::getFields())

                ->endFlexibleContent();

        } else {

            $modulesList

            ->addFlexibleContent('modules', [
                'acfe_flexible_advanced' 	=> 1,
				'acfe_flexible_add_actions' => ['copy'],
				'acfe_flexible_async' 		=> ['layout'],
            ])

                ->addLayout(Header::getFields())

                ->addLayout(TextEditor::getFields())

                ->addLayout(Buttons::getFields())

                ->addLayout(Form::getFields())

                ->addLayout(Accordion::getFields())

                ->addLayout(Html::getFields())

                ->addLayout(ModuleTemplate::getFields())

            ->endFlexibleContent();

        }

		return $modulesList;

	}

}