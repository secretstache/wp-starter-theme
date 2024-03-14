<?php

namespace App\View\Composers\Switches;

use App\View\Composers\SSM;
use App\View\Composers\Templates\Columns;

class Templates extends SSM
{

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'templates.*'
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {

        $templateData = [];
        $template = collect($this->data)->toArray()['template'];

        if (isset($template['context']) && ($template['context'] == 'cb_template' || $template['context'] == 'mb_template')) {
            return [];
        }

        if ($template && $template['acf_fc_layout']) {

            if ($template['acf_fc_layout'] == 'content-block-template') {
                $template = get_field('templates', $template['template_id']) ? array_shift(get_field('templates', $template['template_id'])) : [];
            }

            $templateData = [
                'id'        => self::getCustomID($template['option_html_id']),
                'classes'   => self::getCustomClasses('', $template),
            ];

            switch ($template['acf_fc_layout']) {

                case ('columns'):
                    $templateData = Columns::getTemplateData($template);
                    break;
            }
        }

        return $templateData;
    }
}