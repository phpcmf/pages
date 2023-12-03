<?php

namespace Cmf\Pages\Api\Controller;

use Cmf\Api\Controller\AbstractDeleteController;
use Cmf\Pages\Command\DeletePage;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;

class DeletePageController extends AbstractDeleteController
{
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
    protected function delete(ServerRequestInterface $request)
    {
        $this->bus->dispatch(
            new DeletePage(Arr::get($request->getQueryParams(), 'id'), $request->getAttribute('actor'))
        );
    }
}
