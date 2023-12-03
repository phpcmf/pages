<?php

namespace Cmf\Pages\Api\Controller;

use Cmf\Api\Controller\AbstractListController;
use Cmf\Http\UrlGenerator;
use Cmf\Query\QueryCriteria;
use Cmf\Pages\Api\Serializer\PageSerializer;
use Cmf\Pages\Search\PageFilterer;
use Cmf\Pages\Search\PageSearcher;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ListPagesController extends AbstractListController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = PageSerializer::class;

    /**
     * {@inheritdoc}
     */
    public $sortFields = ['time', 'editTime'];

    /**
     * {@inheritdoc}
     */
    public $sort = ['editTime' => 'desc'];

    /**
     * @var PageSearcher
     */
    protected $searcher;

    /**
     * @var PageFilterer
     */
    protected $filterer;

    /**
     * @var UrlGenerator
     */
    protected $url;

    /**
     * @param PageSearcher $searcher
     * @param PageFilterer $filterer
     * @param UrlGenerator $url
     */
    public function __construct(PageSearcher $searcher, PageFilterer $filterer, UrlGenerator $url)
    {
        $this->searcher = $searcher;
        $this->filterer = $filterer;
        $this->url = $url;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $actor = $request->getAttribute('actor');
        $filters = $this->extractFilter($request);
        $sort = $this->extractSort($request);

        $limit = $this->extractLimit($request);
        $offset = $this->extractOffset($request);
        $include = $this->extractInclude($request);

        $criteria = new QueryCriteria($actor, $filters, $sort);
        if (array_key_exists('q', $filters)) {
            $results = $this->searcher->search($criteria, $limit, $offset);
        } else {
            $results = $this->filterer->filter($criteria, $limit, $offset);
        }

        $document->addPaginationLinks(
            $this->url->to('api')->route('pages.index'),
            $request->getQueryParams(),
            $offset,
            $limit,
            $results->areMoreResults() ? null : 0
        );

        return $results->getResults()->load($include);
    }
}
