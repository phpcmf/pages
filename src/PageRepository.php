<?php

namespace Cmf\Pages;

use Cmf\User\Guest;
use Cmf\User\User;
use Illuminate\Database\Eloquent\Builder;

class PageRepository
{
    /**
     * Get a new query builder for the pages table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Page::query();
    }

    /**
     * Find a page by ID.
     *
     * @param int  $id
     * @param User $user
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return Page
     */
    public function findOrFail($id, User $user = null)
    {
        return $this->query()
            // We never pass a null $user from our own code, but third-party extensions
            // like v17development/cmf-seo do it so we must allow null for backward compatibility
            ->whereVisibleTo($user ?? new Guest())
            ->where(function (Builder $builder) use ($id) {
                $builder->where('id', $id)->orWhere('slug', $id);
            })
            ->firstOrFail();
    }
}
