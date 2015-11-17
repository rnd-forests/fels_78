<?php

namespace FELS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\DomCrawler\Crawler;

class FilterPjaxRequest
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response->isRedirection() || !$request->pjax()) {
            return $response;
        }

        $this->filterResponse($response, $request->header('X-PJAX-CONTAINER'))
            ->setUriHeader($response, $request);

        return $response;
    }

    /**
     * Get the PJAX response's content.
     *
     * @param Response $response
     * @param $container
     * @return $this
     */
    protected function filterResponse($response, $container)
    {
        $crawler = new Crawler($response->getContent());

        $response->setContent(
            $this->makeTitle($crawler) . $this->fetchContainerHtml($crawler, $container)
        );

        return $this;
    }

    /**
     * Prepare an HTML title.
     *
     * @param  Crawler $crawler
     * @return string
     */
    protected function makeTitle($crawler)
    {
        $pageTitle = $crawler->filter('head > title')->html();

        return "<title>{$pageTitle}</title>";
    }

    /**
     * Fetch PJAX html from the response.
     *
     * @param Crawler $crawler
     * @param $container
     * @return string|void
     */
    protected function fetchContainerHtml($crawler, $container)
    {
        $content = $crawler->filter($container);

        if (!$content->count()) {
            abort(422);
        }

        return $content->html();
    }

    /**
     * Set the PJAX-URL header to the current URI.
     *
     * @param Response $response
     * @param Request $request
     */
    protected function setUriHeader($response, $request)
    {
        $response->header('X-PJAX-URL', $request->getRequestUri());
    }
}
