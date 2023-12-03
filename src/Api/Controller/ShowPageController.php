<?php

namespace Cmf\Pages\Api\Controller;

use Cmf\Api\Controller\AbstractShowController;
use Cmf\Pages\Api\Serializer\PageSerializer;
use Cmf\Pages\PageRepository;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ShowPageController extends AbstractShowController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = PageSerializer::class;

    /**
     * @var PageRepository
     */
    protected $pages;

    /**
     * @param PageRepository $pages
     */
    public function __construct(PageRepository $pages)
    {
        $this->pages = $pages;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $id = Arr::get($request->getQueryParams(), 'id');

        $actor = $request->getAttribute('actor');

        return $this->pages->findOrFail($id, $actor);
    }
}
