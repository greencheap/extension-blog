<?php
return [
    'name' => 'blog',

    'main' => function ($app) {
    },

    'autoload' => [
        'GreenCheap\\Blog\\' => 'src'
    ],

    'menu' => [
        'blog' => [
            'label' => 'Blog',
            'icon' => 'blog:icon.svg',
            'url' => '@blog/post',
            'active' => '@blog/post*',
            'access' => 'blog: manage own posts || blog: manage all posts || blog: manage comments || system: access settings',
            'priority' => 110
        ],
        'blog: posts' => [
            'label' => 'Posts',
            'parent' => 'blog',
            'url' => '@blog/post',
            'active' => '@blog/post*',
            'access' => 'blog: manage own posts || blog: manage all posts'
        ],
        'blog: settings' => [
            'label' => 'Settings',
            'parent' => 'blog',
            'url' => '@blog/settings',
            'active' => '@blog/settings*',
            'access' => 'system: access settings'
        ]

    ],

    'routes' => [
        '/blog' => [
            'name' => '@blog',
            'controller' => 'GreenCheap\\Blog\\Controller\\BlogController'
        ],
        '/api/blog' => [
            'name' => '@blog/api',
            'controller' => [
                //'GreenCheap\\Blog\\Controller\\PostApiController',
                //'GreenCheap\\Blog\\Controller\\CommentApiController'
            ]
        ]
    ],

    'permissions' => [
        'blog: manage own posts' => [
            'title' => 'Manage own posts',
            'description' => 'Create, edit, delete and publish posts of their own'
        ],
        'blog: manage all posts' => [
            'title' => 'Manage all posts',
            'description' => 'Create, edit, delete and publish posts by all users'
        ],
        'blog: manage comments' => [
            'title' => 'Manage comments',
            'description' => 'Approve, edit and delete comments'
        ],
        'blog: post comments' => [
            'title' => 'Post comments',
            'description' => 'Allowed to write comments on the site'
        ],
        'blog: skip comment approval' => [
            'title' => 'Skip comment approval',
            'description' => 'User can write comments without admin approval'
        ],
        'blog: comment approval required once' => [
            'title' => 'Comment approval required only once',
            'description' => 'First comment needs to be approved, later comments are approved automatically'
        ],
        'blog: skip comment min idle' => [
            'title' => 'Skip comment minimum idle time',
            'description' => 'User can write multiple comments without having to wait in between'
        ]
    ],

];
