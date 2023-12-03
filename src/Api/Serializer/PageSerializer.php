<?php

namespace Cmf\Pages\Api\Serializer;

use Cmf\Api\Serializer\AbstractSerializer;
use Cmf\Pages\Page;
use Cmf\Pages\Util\Html;

class PageSerializer extends AbstractSerializer
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'pages';

    /**
     * @param Page $page
     *
     * @return array
     */
    protected function getDefaultAttributes($page)
    {
        $attributes = [
            'id'          => $page->id,
            'title'       => $page->title,
            'slug'        => $page->slug,
            'time'        => $page->time,
            'editTime'    => $page->edit_time,
            'contentHtml' => Html::render($page->content_html, $page),
            'isHtml'      => $page->is_html,
        ];

        if ($this->actor->isAdmin()) {
            $attributes['content'] = $page->content;
            $attributes['isHidden'] = $page->is_hidden;
            $attributes['isRestricted'] = $page->is_restricted;
        }

        return $attributes;
    }
}
