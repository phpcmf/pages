<?php

namespace Cmf\Pages\Search;

use Cmf\Filter\AbstractFilterer;
use Cmf\User\User;
use Cmf\Pages\PageRepository;
use Illuminate\Database\Eloquent\Builder;

class PageFilterer extends AbstractFilterer
{
    /**
     * @var PageRepository
     */
    protected $pages;

    public function __construct(array $filters, array $filterMutators, PageRepository $pages)
    {
        parent::__construct($filters, $filterMutators);

        $this->pages = $pages;
    }

    protected function getQuery(User $actor): Builder
    {
        return $this->pages->query();
    }
}
