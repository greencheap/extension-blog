<?php

namespace GreenCheap\Blog\Event;

use GreenCheap\Application as App;
use GreenCheap\Blog\UrlResolver;
use GreenCheap\Event\EventSubscriberInterface;

/**
 * Class RouteListener
 * @package GreenCheap\Blog\Event
 */
class RouteListener implements EventSubscriberInterface
{
    /**
     * Adds cache breaker to router.
     */
    public function onAppRequest()
    {
        App::router()->setOption('blog.permalink', UrlResolver::getPermalink());
    }

    /**
     * Registers permalink route alias.
     * @param $event
     * @param $route
     */
    public function onConfigureRoute($event, $route)
    {
        if ($route->getName() == '@blog/id' && UrlResolver::getPermalink()) {
            App::routes()->alias(dirname($route->getPath()).'/'.ltrim(UrlResolver::getPermalink(), '/'), '@blog/id', ['_resolver' => 'GreenCheap\Blog\UrlResolver']);
        }
    }

    /**
     * Clears resolver cache.
     */
    public function clearCache()
    {
        App::cache()->delete(UrlResolver::CACHE_KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'request' => ['onAppRequest', 130],
            'route.configure' => 'onConfigureRoute',
            'model.post.saved' => 'clearCache',
            'model.post.deleted' => 'clearCache'
        ];
    }
}
