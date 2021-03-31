<?php

namespace GreenCheap\Blog\Controller;

use GreenCheap\Application as App;
use GreenCheap\Blog\Model\Post;
use GreenCheap\System\Service\StatusModelService;
use GreenCheap\User\Model\Role;
use GreenCheap\User\Model\User;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @Access(admin=true)
 */
class BlogController
{
    /**
     * @Access("blog: manage own posts || blog: manage all posts")
     * @Request({"filter": "array", "page":"int"})
     * @param null $filter
     * @param null $page
     * @return array[]
     */
    #[ArrayShape(['$view' => "array", '$data' => "array"])]
    public function postAction($filter = null, $page = null): array
    {

        $db = App::db();

        $categories = $db->createQueryBuilder()
            ->select(['id', 'title'])
            ->from('@blog_categories')
            ->where('status = ?', [StatusModelService::getStatus('STATUS_PUBLISHED')])
            ->get();

        return [
            '$view' => [
                'title' => __('Posts'),
                'name'  => 'blog/admin/index.php'
            ],
            '$data' => [
                'statuses' => StatusModelService::getStatuses(),
                'categories' => $categories,
                'authors'  => User::findAll(),
                'canEditAll' => App::user()->hasAccess('blog: manage all posts'),
                'config'   => [
                    'filter' => (object) $filter,
                    'page'   => $page
                ]
            ]
        ];
    }

    /**
     * @Route("/post/edit", name="post/edit")
     * @Access("blog: manage own posts || blog: manage all posts")
     * @Request({"id": "int"})
     * @param int $id
     * @return array|void
     */
    public function editAction($id = 0): array
    {
        if (!$query = Post::where(compact('id'))->first()) {
            if ($id) {
                return App::abort(404, __('Not Found Post'));
            }

            $module = App::module('blog');

            $query = Post::create([
                'date' => new \DateTime,
                'user_id' => App::user()->id,
                'status' => StatusModelService::getStatus('STATUS_PUBLISHED')
            ]);

            $query->set('markdown', $module->config('posts.markdown_enabled'));
            $query->set('comment_status', $module->config('posts.comments_enabled'));
        }

        $user = App::user();
        if (!$user->hasAccess('blog: manage all posts') && $query->user_id !== $user->id) {
            App::abort(403, __('Insufficient User Rights.'));
        }

        $roles = App::db()->createQueryBuilder()
            ->from('@system_role')
            ->where(['id' => Role::ROLE_ADMINISTRATOR])
            ->whereInSet('permissions', ['blog: manage all posts', 'blog: manage own posts'], false, 'OR')
            ->execute('id')
            ->fetchAll(\PDO::FETCH_COLUMN);

        $authors = App::db()->createQueryBuilder()
            ->from('@system_user')
            ->whereInSet('roles', $roles)
            ->execute('id, username')
            ->fetchAll();

        $categories = App::db()->createQueryBuilder()
            ->select(['id', 'title'])
            ->from('@blog_categories')
            ->where('status = ?', [StatusModelService::getStatus('STATUS_PUBLISHED')])
            ->orderBy('title', 'asc')
            ->get();

        return [
            '$view' => [
                'title' => $query->id ? __('Edit %title%', ['%title%' => $query->title]) : __('New Post'),
                'name' => 'blog:views/admin/edit.php'
            ],
            '$data' => [
                'post' => $query,
                'data' => [
                    'users' => User::findAll(),
                    'statuses' => StatusModelService::getStatuses(),
                    'roles'    => array_values(Role::findAll()),
                    'canEditAll' => $user->hasAccess('blog: manage all posts'),
                    'categories' => $categories
                ]
            ]
        ];
    }

    /**
     * @Access("system: access settings")
     */
    public function settingsAction(): array
    {
        return [
            '$view' => [
                'title' => __('Blog Settings'),
                'name'  => 'blog/admin/settings.php'
            ],
            '$data' => [
                'config' => App::module('blog')->config()
            ]
        ];
    }
}
