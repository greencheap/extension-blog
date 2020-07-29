<?php
namespace GreenCheap\Blog\Controller;

use GreenCheap\Application as App;
use GreenCheap\Blog\Model\Post;
use GreenCheap\Categories\Service\CategoriesService;
use GreenCheap\System\Model\StatusModelTrait;
use GreenCheap\User\Model\Role;
use GreenCheap\User\Model\User;

/**
 * @Access(admin=true)
 */
class BlogController
{
    /**
     * @var CategoriesService
     */
    protected $categories;

    /**
     * BlogController constructor.
     */
    public function __construct()
    {
        $this->categories = new CategoriesService();
    }

    /**
     * @Access("blog: manage own posts || blog: manage all posts")
     * @Request({"filter": "array", "page":"int"})
     * @param null $filter
     * @param null $page
     * @return array[]
     */
    public function postAction($filter = null, $page = null)
    {
        return [
            '$view' => [
                'title' => __('Posts'),
                'name'  => 'blog/admin/index.php'
            ],
            '$data' => [
                'statuses' => StatusModelTrait::getStatuses(),
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
    public function editAction($id = 0)
    {
        if( !$query = Post::where(compact('id'))->first() ){
            if($id){
                return App::abort(404 , __('Not Found Post'));
            }

            $query = Post::create([
                'date' => new \DateTime,
                'user_id' => App::user()->id,
                'status' => StatusModelTrait::getStatus('STATUS_PUBLISHED')
            ]);
        }

        $user = App::user();
        if(!$user->hasAccess('blog: manage all posts') && $query->user_id !== $user->id) {
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
                'title' => 'Hello',
                'name' => 'blog:views/admin/edit.php'
            ],
            '$data' => [
                'post' => $query,
                'data' => [
                    'categories' => $this->categories->getAll('blog'),
                    'users' => User::findAll(),
                    'statuses' => StatusModelTrait::getStatuses(),
                    'roles'    => array_values(Role::findAll()),
                    'canEditAll' => $user->hasAccess('blog: manage all posts'),
                ]
            ]
        ];
    }

    /**
     * @Access("system: access settings")
     */
    public function settingsAction()
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
