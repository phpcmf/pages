<?php

namespace Cmf\Pages\Search;

use Cmf\Search\AbstractSearcher;
use Cmf\Search\GambitManager;
use Cmf\User\User;
use Cmf\Pages\PageRepository;
use Illuminate\Database\Eloquent\Builder;

class PageSearcher extends AbstractSearcher
{
    /**
     * @var PageRepository
     */
    protected $pages;

    public function __construct(GambitManager $gambits, array $searchMutators, PageRepository $pages)
    {
        parent::__construct($gambits, $searchMutators);

        $this->pages = $pages;
    }

    protected function getQuery(User $actor): Builder
    {
        return $this->pages->query();
    }
}
