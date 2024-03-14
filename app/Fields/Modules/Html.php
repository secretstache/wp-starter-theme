<?php

namespace App\Fields\Modules;

use App\Fields\Options\Admin;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\ModuleMargins;

class Html {

	public static function getFields() {

		/**
         * [Module] - HTML
         * @author Rich Staats <rich@secretstache.com>
         * @since 3.0.0
         * @todo Link to Team Snippet Code
         */
        $htmlModule = new FieldsBuilder('html', [
            'title'	=> 'HTML'
        ]);

        $htmlModule

            ->addTab('Content')

                ->addField('inline_html', 'acfe_code_editor', [
                    'label'		=> false,
                    'mode' 		=> 'text/html',
                    'rows' 		=> 2,
                    'max_rows'  => 4
                ])

            ->addTab('Options')

                ->addFields(ModuleMargins::getFields()) 

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());

		return $htmlModule;

	}

}