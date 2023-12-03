<?php

namespace Cmf\Pages\Search;

use Cmf\Filter\FilterInterface;
use Cmf\Filter\FilterState;
use Cmf\Search\GambitInterface;
use Cmf\Search\SearchState;

/**
 * We need to register at least one gambit for the searcher or filter, but we don't actually have any
 * We only configure the searcher/filterer so we can use pagination and for extensions to hook into.
 */
class NoOpGambit implements GambitInterface, FilterInterface
{
    public function getFilterKey(): string
    {
        return 'noop';
    }

    public function filter(FilterState $filterState, string $filterValue, bool $negate)
    {
        // Does nothing
    }

    public function apply(SearchState $search, $bit)
    {
        // Does nothing
    }
}
