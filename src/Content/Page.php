<?php

namespace Cmf\Pages\Content;

use Cmf\Api\Client;
use Cmf\Frontend\Document;
use Cmf\Http\Exception\RouteNotFoundException;
use Cmf\Http\UrlGenerator;
use Cmf\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;

class Page
{
    /**
     * @var Client
     */
    protected $api;

    /**
     * @var UrlGenerator
     */
    protected $url;

    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @var Factory
     */
    protected $view;

    public function __construct(Client $api, UrlGenerator $url, SettingsRepositoryInterface $settings, Factory $view)
    {
        $this->api = $api;
        $this->url = $url;
        $this->settings = $settings;
        $this->view = $view;
    }

    public function __invoke(Document $document, ServerRequestInterface $request)
    {
        $queryParams = $request->getQueryParams();

        $id = Arr::get($queryParams, 'id') ?? $this->settings->get('pages_home');

        $apiDocument = $this->getApiDocument($request, $id);

        $document->title = $apiDocument->data->attributes->title;

        $document->content = $this->view->make('cmf-pages::content.page', compact('apiDocument'));

        $document->payload['apiDocument'] = $apiDocument;
    }

    private function getApiDocument(ServerRequestInterface $request, $id)
    {
        $response = $this->api->withParentRequest($request)->get('/pages/'.$id);

        if ($response->getStatusCode() === 404) {
            throw new RouteNotFoundException();
        }

        return json_decode($response->getBody());
    }
}
