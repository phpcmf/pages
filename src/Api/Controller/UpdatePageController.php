<?php

namespace Cmf\Pages\Api\Controller;

use Cmf\Api\Controller\AbstractShowController;
use Cmf\Pages\Api\Serializer\PageSerializer;
use Cmf\Pages\Command\EditPage;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class UpdatePageController extends AbstractShowController
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
        $id = Arr::get($request->getQueryParams(), 'id');
        $actor = $request->getAttribute('actor');
        $data = Arr::get($request->getParsedBody(), 'data');

        return $this->bus->dispatch(
            new EditPage($id, $actor, $data)
        );
    }
}
