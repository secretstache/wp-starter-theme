<?php

namespace App\Fields\Modules;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Options\ModuleMargins;
use App\Fields\Options\HtmlAttributes;
use App\Fields\Options\Admin;

class LottieAnimation
{

    public static function getFields()
    {

        /**
         * [Module] - Lottie Animation
         */
        $lottieAnimationModule = new FieldsBuilder('lottie-animation', [
            'title'    => 'Lottie Animation'
        ]);

        $lottieAnimationModule

            ->addTab('Content')

                ->addFile('animation_file', [
                    'label'        => 'Upload File',
                    'mime_types'   => 'json',
                ])

            ->addTab('Options')

                ->addFields(ModuleMargins::getFields())

                ->addFields(HtmlAttributes::getFields())

            ->addTab('Admin')

                ->addFields(Admin::getFields());

        return $lottieAnimationModule;
    }
}
