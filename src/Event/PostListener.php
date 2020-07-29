<?php

namespace GreenCheap\Blog\Event;

use GreenCheap\Blog\Model\Post;
use GreenCheap\Event\EventSubscriberInterface;

class PostListener implements EventSubscriberInterface
{
    /**
     * @param $event
     * @param $role
     */
    public function onRoleDelete($event, $role)
    {
        Post::removeRole($role);
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'model.role.deleted' => 'onRoleDelete'
        ];
    }
}
