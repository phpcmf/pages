<?php

namespace Cmf\Pages\Command;

use Cmf\Pages\Page;
use Cmf\Pages\PageValidator;
use Illuminate\Support\Arr;

class CreatePageHandler
{
    /**
     * @var PageValidator
     */
    protected $validator;

    /**
     * @param PageValidator $validator
     */
    public function __construct(PageValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param CreatePage $command
     *
     * @throws \Cmf\User\Exception\PermissionDeniedException
     *
     * @return Page
     */
    public function handle(CreatePage $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $actor->assertAdmin();

        $page = Page::build(
            Arr::get($data, 'attributes.title'),
            Arr::get($data, 'attributes.slug'),
            Arr::get($data, 'attributes.content'),
            Arr::get($data, 'attributes.isHidden'),
            Arr::get($data, 'attributes.isRestricted'),
            Arr::get($data, 'attributes.isHtml')
        );

        $this->validator->assertValid($page->getAttributes());

        $page->save();

        return $page;
    }
}
