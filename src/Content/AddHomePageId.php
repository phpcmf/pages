<?php

namespace Cmf\Pages\Content;

use Cmf\Frontend\Document;
use Cmf\Settings\SettingsRepositoryInterface;

class AddHomePageId
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function __invoke(Document $document)
    {
        if (($id = $this->settings->get('pages_home')) != null) {
            $document->payload['cmf-pages.home'] = $id;
        }
    }
}
