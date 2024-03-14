<?php

namespace App\View\Composers\Templates;

use App\View\Composers\Switches\Templates;

class Columns extends Templates
{

    public static function getTemplateData($template)
    {
        $columnsData = [];

        if ($template['columns']) {
            if (count($template['columns']) == 2) {
                $column_width        = [$template['two_column_layout']['left_column_width'], $template['two_column_layout']['right_column_width']];
                $column_alignment_x  = $template['two_column_layout']['alignment_x'];
                $column_alignment_y  = $template['two_column_layout']['alignment_y'];
                $column_mobile_order = ($template['option_columns_mobile_order']) ? explode('_', $template['option_columns_mobile_order']) : '1';
            }

            $column_options = array_map(function ($column) {
                return [
                    'id'         => ($column['option_html_id']) ? 'id="' . $column['option_html_id'] . '"' : '',
                    'classes'    => ($column['option_html_classes']) ? ' ' . $column['option_html_classes'] : '',
                ];
            }, $template['columns'] ?: []);
        }

        $columnsData = [
            'id'                    => self::getCustomID($template['option_html_id']),
            'classes'               => self::getCustomClasses('', $template),
            'column_options'        => $column_options ?? [null],
            'column_width'          => $column_width ?? null,
            'column_mobile_order'   => $column_mobile_order ?? null,
            'container_width'       => ' container-width-' . $template['container_options']['width'],
            'container_alignment'   => ' container-align-' . $template['container_options']['alignment_x'],
            'column_alignment_x'    => isset($column_alignment_x) ? ' align-' . $column_alignment_x : null,
            'column_alignment_y'    => isset($column_alignment_y) ? ' align-' . $column_alignment_y : null,
        ];

        return $columnsData;
    }
}