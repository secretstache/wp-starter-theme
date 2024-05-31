<?php

namespace App\View\Composers\Templates;

use App\View\Composers\Switches\Templates;

class RelatedContent extends Templates
{
    public static function getTemplateData($template)
    {
        $relatedContentData = [];

        if ($template['query'] == 'latest') {

            $posts = self::getPosts('post', $template['posts_number']);
            
        } elseif ($template['query'] == 'category' && $template['categories']) {

            $posts = self::getPosts('post', $template['posts_number'], $template['categories']);

        } elseif ($template['query'] == 'topic' && $template['topics']) {

            $posts = self::getPosts('post', $template['posts_number'], $template['topics']);

        } elseif ($template['query'] == 'curated') {

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
