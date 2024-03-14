<?php

namespace App\View\Composers\Switches;

use App\View\Composers\SSM;

class Modules extends SSM
{

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'modules.*'
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {

        $data = collect($this->data)->toArray();

        if (isset($data['module']) && !empty($data['module'])) {

            $module = $data['module'];

            $moduleData = [
                'module_id'         => self::getCustomID($module['option_html_id']),
                'module_classes'    => self::getCustomClasses('', $module),
            ];

            if ($module && $module['acf_fc_layout']) {

                switch ($module['acf_fc_layout']) {

                    case 'header':

                        $headline_items = array_map(function ($headline_item) {
                            return [
                                "headline"         => $headline_item['headline'],
                                "headline_tag"     => $headline_item['headline_tag'],
                                "headline_class"   => ($headline_item['headline_display'] != 'default') ? $headline_item['headline_display'] : $headline_item['headline_tag'],
                            ];
                        }, $module['headlines'] ?: []);
                        
                        $moduleData['headline_items'] = $headline_items ?? [];
                        break;

                    case 'image':

                        if ($module['include_image_link']) {
                            if ($module['link_source'] == 'internal' && $module['link_page_id']) {
                                $moduleData['image_link']   = get_permalink($module['link_page_id']);
                                $moduleData['image_target'] = '_self';
                            } elseif ($module['link_source'] == 'external' && $module['link_url']) {
                                $moduleData['image_link']   = $module['link_url'];
                                $moduleData['image_target'] = '_blank';
                            }
                        }

                        $moduleData['image'] = $module['image'];
                        break;

                    case 'form':

                        $moduleData['form_id'] = $module['form']['id'];
                        break;
                }
            }
        }

        return $moduleData ?? [];
    }
}