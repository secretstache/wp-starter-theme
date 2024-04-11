<?php

namespace App\Fields\Modules;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Options\Admin;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\ModuleMargins;

class Table {

	public static function getFields() {

		/**
         * [Module] - Table
         */
        $tableModule = new FieldsBuilder('table', [
            'title'	=> 'Table'
        ]);

        $tableModule

            ->addTab('Content')

                ->addField('table', 'table', [
                    'label'     => false
                ])

            ->addTab('Options')

                ->addFields(ModuleMargins::getFields())

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());

		return $tableModule;

	}

}