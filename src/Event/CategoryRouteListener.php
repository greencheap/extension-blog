<?php

namespace GreenCheap\Blog\Event;

use GreenCheap\Application as App;
use GreenCheap\Blog\CategoryUrlResolver;
use GreenCheap\Event\EventSubscriberInterface;

/**
 * Class RouteListener
 * @package GreenCheap\Blog\Event
 */
class CategoryRouteListener implements EventSubscriberInterface
{
    /**
     * Adds cache breaker to router.
     */
    public function onAppRequest()
    {
        App::router()->setOption('blog.permalink', CategoryUrlResolver::getPermalink());
    }

    /**
     * Registers permalink route alias.
     * @param $event
     * @param $route
     */
    public function onConfigureRoute($event, $route)
    {
        if ($route->getName() == '@blog/category/id' && CategoryUrlResolver::getPermalink()) {
            App::routes()->alias(dirname($route->getPath()).'/'.ltrim(CategoryUrlResolver::getPermalink(), '/'), '@blog/category/id', ['_resolver' => 'GreenCheap\Blog\CategoryUrlResolver']);
        }
    }

    /**
     * Clears resolver cache.
     */
    public function clearCache()
    {
        App::cache()->delete(CategoryUrlResolver::CACHE_KEY);
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
