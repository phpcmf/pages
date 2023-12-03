<?php

namespace Cmf\Pages\Access;

use Cmf\User\User;
use Illuminate\Database\Eloquent\Builder;

class ScopePageVisibility
{
    public function __invoke(User $actor, Builder $query)
    {
        if (!$actor->hasPermission('cmf-pages.viewHidden')) {
            $query->whereIsHidden(0);
        }

        if (!$actor->hasPermission('cmf-pages.viewRestricted')) {
            $query->whereIsRestricted(0);
        }
    }
}
