<?php

namespace App\Fields\Modules;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Components\TextEditor as TextEditorComponent;
use App\Fields\Options\Admin;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\ModuleAlignment;
use App\Fields\Options\ModuleMargins;

class TextEditor {

	public static function getFields() {

		/**
         * [Module] - Text Editor
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Link to Team Snippet Code
         */
        $textEditorModule = new FieldsBuilder('text-editor', [
            'title'	=> 'Text Editor'
        ]);

        $textEditorModule

            ->addTab('Content')

                ->addFields(TextEditorComponent::getFields( $type = '', $label = '' ))

            ->addTab('Options')

                ->addFields(ModuleMargins::getFields())

                ->addFields(ModuleAlignment::getFields())

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());

		return $textEditorModule;

	}

}