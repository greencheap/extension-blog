<?php

namespace GreenCheap\Blog\Controller;

use GreenCheap\Application as App;
use GreenCheap\Blog\Model\Categories;
use GreenCheap\System\Service\StatusModelService;
use GreenCheap\User\Model\Role;
use GreenCheap\User\Model\User;

/**
 * Class CategoriesController
 * @package GreenCheap\Blog\Controller
 * @Access("blog: manage all posts" , admin=true)
 * @Route("/categories" , name="admin/categories")
 */
class CategoriesController
{
    /**
     * @param $filter
     * @param $page
     * @return array|string
     * @Request({"filter":"array", "page":"int"})
     */
    public function indexAction($filter = null, $page = null): array|string
    {
        return [
            '$view' => [
                'title' => __('Categories'),
                'name' => 'blog:views/admin/categories-index.php'
            ],
            '$data' => [
                'authors'  => User::findAll(),
                'canEditAll' => App::user()->hasAccess('blog: manage all posts'),
                'config' => [
                    'filter' => (object) $filter,
                    'page' => (int) $page
                ],
                'statuses' => StatusModelService::getStatuses()
            ]
        ];
    }

    /**
     * @Request({"id":"integer"})
     * @param int $id
     * @return array
     */
    public function editAction(int $id = 0): array
    {
        $module = App::module('blog');
        if (!$query = Categories::where(compact('id'))->first()) {
            if ($id) {
                return App::abort(404, __('Not Found Category'));
            }

            $query = Categories::create([
                'date' => new \DateTime(),
                'user_id' => App::user()->id,
                'status' => StatusModelService::getStatus('STATUS_PUBLISHED')
            ]);

            $query->set('markdown', $module->config('posts.markdown_enabled'));
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

        return [
            '$view' => [
                'title' => $query->id ? __('Edit %title%', ['%title%' => $query->title]) : __('New Category'),
                'name' => 'blog:views/admin/categories-edit.php'
            ],
            '$data' => [
                'category' => $query,
                'data' => [
                    'users' => User::findAll(),
                    'statuses' => StatusModelService::getStatuses(),
                    'roles'    => array_values(Role::findAll()),
                    'canEditAll' => $user->hasAccess('blog: manage all posts'),
                ]
            ]
        ];
    }
}
