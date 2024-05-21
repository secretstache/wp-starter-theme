<?php

namespace App\View\Composers\Templates;

use App\View\Composers\Switches\Templates;

class RelatedContent extends Templates
{
    public static function getTemplateData($template)
    {

        $relatedContentData = [];

        $args = [
            'post_type'         => 'post',
            'posts_per_page'    => $template['posts_number'] ?: 6,
            'status'            => 'publish',
            'fields'            => 'ids'
        ];

        if ($template['query'] == 'latest') {

            $posts = get_posts($args);

        } elseif ($template['query'] == 'category' && $template['categories']) {

            $args['tax_query'] = [
                [
                    'taxonomy'      => 'category',
                    'field'         => 'slug',
                    'terms'         => array_column($template['categories'], 'slug'),
                ]
            ];

            $posts = get_posts($args);

        } elseif ($template['query'] == 'topic' && $template['topics']) {

            $args['tax_query'] = [
                [
                    'taxonomy' => 'ssm_resource_topic',
                    'field'    => 'slug',
                    'terms'    => array_column($template['topics'], 'slug'),
                ]
            ];

            $posts = get_posts($args);

        } elseif ($template['query'] == 'curated' && $template['posts']) {

            $posts = $template['posts'];

        }

        $relatedContentData = [
            'id'            => self::getCustomID($template['option_html_id']),
            'classes'       => self::getCustomClasses('', $template),
            'posts'         => $posts ?? []
        ];

        return $relatedContentData;
    }
}