<?php

namespace Cmf\Pages\Command;

use Cmf\Settings\SettingsRepositoryInterface;
use Cmf\Pages\PageRepository;

class DeletePageHandler
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @var PageRepository
     */
    protected $pages;

    /**
     * @param PageRepository $pages
     */
    public function __construct(PageRepository $pages, SettingsRepositoryInterface $settings)
    {
        $this->pages = $pages;
        $this->settings = $settings;
    }

    /**
     * @param DeletePage $command
     *
     * @throws \Cmf\User\Exception\PermissionDeniedException
     *
     * @return \Cmf\Pages\Page
     */
    public function handle(DeletePage $command)
    {
        $actor = $command->actor;

        $page = $this->pages->findOrFail($command->pageId, $actor);

        $actor->assertAdmin();

        // if it has been set as home page revert back to default router
        $homePage = intval($this->settings->get('pages_home'));
        if ($homePage && $page->id === $homePage) {
            $this->settings->delete('pages_home');
            $this->settings->set('default_route', '/all');
        }

        $page->delete();

        return $page;
    }
}
