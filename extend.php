<?php

namespace Cmf\Pages;

use Cmf\Extend;
use Cmf\Pages\Api\Controller;

return [
    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Frontend('admin'))
        ->css(__DIR__.'/less/admin.less')
        ->js(__DIR__.'/js/dist/admin.js'),

    (new Extend\Frontend('site'))
        ->css(__DIR__.'/less/site.less')
        ->js(__DIR__.'/js/dist/site.js')
        ->route('/pages/home', 'pages.home')
        ->route('/pages/{id:[\d\S]+(?:-[^/]*)?}', 'pages.page', Content\Page::class)
        ->content(Content\AddHomePageId::class),

    (new Extend\Routes('api'))
        ->get('/pages', 'pages.index', Controller\ListPagesController::class)
        ->post('/pages', 'pages.create', Controller\CreatePageController::class)
        ->get('/pages/{id}', 'pages.show', Controller\ShowPageController::class)
        ->patch('/pages/{id}', 'pages.update', Controller\UpdatePageController::class)
        ->delete('/pages/{id}', 'pages.delete', Controller\DeletePageController::class),

    (new Extend\View())
        ->namespace('cmf-pages', __DIR__.'/views'),

    (new Extend\ModelVisibility(Page::class))
        ->scope(Access\ScopePageVisibility::class),

    (new Extend\Filter(Search\PageFilterer::class))
        ->addFilter(Search\NoOpGambit::class),

    (new Extend\SimpleCmfSearch(Search\PageSearcher::class))
        ->setFullTextGambit(Search\NoOpGambit::class),

    (new Extend\ServiceProvider())
        ->register(Providers\PageServiceProvider::class),
];
