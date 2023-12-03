<?php

namespace Cmf\Pages\Providers;

use Cmf\Formatter\Formatter;
use Cmf\Foundation\AbstractServiceProvider;
use Cmf\Foundation\Paths;
use Cmf\Pages\Page;

class PageServiceProvider extends AbstractServiceProvider
{
    public function boot()
    {
        $this->container->instance('path.pages', $this->container->make(Paths::class)->base.DIRECTORY_SEPARATOR.'pages');

        Page::setFormatter($this->container->make(Formatter::class));
    }
}
