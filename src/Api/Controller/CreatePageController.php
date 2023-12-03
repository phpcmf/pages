<?php

namespace Cmf\Pages\Api\Controller;

use Cmf\Api\Controller\AbstractCreateController;
use Cmf\Pages\Api\Serializer\PageSerializer;
use Cmf\Pages\Command\CreatePage;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class CreatePageController extends AbstractCreateController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = PageSerializer::class;

    /**
     * @var Dispatcher
     */
    protected $bus;

    /**
     * @param Dispatcher $bus
     */
    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        return $this->bus->dispatch(
            new CreatePage($request->getAttribute('actor'), Arr::get($request->getParsedBody(), 'data'))
        );
    }
}
