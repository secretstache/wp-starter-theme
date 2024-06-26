<?php

namespace App\Fields\Modules;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Options\Admin;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\ModuleAlignment;
use App\Fields\Options\ModuleMargins;

class TextEditor {

	public static function getFields() {

		/**
         * [Module] - Text Editor
         */
        $textEditorModule = new FieldsBuilder('text-editor', [
            'title'	=> 'Text Editor'
        ]);

        $textEditorModule

            ->addTab('Content')

                ->addWysiwyg('text_editor', [
                    'label'         => false,
                    'toolbar'       => 'full',
                    'media_upload'  => 1
                ])

            ->addTab('Options')

                ->addFields(ModuleMargins::getFields())

                ->addFields(ModuleAlignment::getFields())

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());

		return $textEditorModule;

	}

}