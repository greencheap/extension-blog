<?php
namespace GreenCheap\Blog\Controller;

use GreenCheap\Application as App;
use GreenCheap\Blog\Model\Categories;

/**
 * Class ApiCategoriesController
 * @package GreenCheap\Blog\Controller
 * @Access("blog: manage own posts || blog: manage all posts", admin=true)
 * @Route("category", name="category")
 */
class ApiCategoriesController
{
    /**
     * @Route("/", methods="GET")
     * @Request({"filter": "array", "page":"int"})
     * @param array $filter
     * @param int $page
     * @return array
     */
    public function indexAction( array $filter = [], int $page = 0)
    {
        $query  = Categories::query();
        $filter = array_merge(array_fill_keys(['status', 'search', 'author', 'order', 'limit'], ''), $filter);

        extract($filter, EXTR_SKIP);

        if(!App::user()->hasAccess('blog: manage all posts')) {
            $author = App::user()->id;
        }

        if (is_numeric($status)) {
            $query->where(['status' => (int) $status]);
        }

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->orWhere(['title LIKE :search', 'slug LIKE :search'], ['search' => "%{$search}%"]);
            });
        }

        if ($author) {
            $query->where(function ($query) use ($author) {
                $query->orWhere(['user_id' => (int) $author]);
            });
        }

        if (!preg_match('/^(date|title)\s(asc|desc)$/i', $order, $order)) {
            $order = [1 => 'date', 2 => 'desc'];
        }

        $limit = (int) $limit ?: App::module('blog')->config('posts.posts_per_page');
        $count = $query->count();
        $pages = ceil($count / $limit);
        $page  = max(0, min($pages - 1, $page));

        $categories = array_values($query->offset($page * $limit)->related('user')->limit($limit)->orderBy($order[1], $order[2])->get());

        return compact('categories', 'pages', 'count');
    }

    /**
     * @Route("/", methods="POST")
     * @Route("/{id}", methods="POST", requirements={"id"="\d+"})
     * @Request({"data":"array","id":"integer"} , csrf=true)
     */
    public function saveAction(array $data = [] , int $id = 0)
    {
        if (!$id || !$category = Categories::find($id)) {

            if ($id) {
                return App::jsonabort(404, __('Categories not found.'));
            }

            $category = Categories::create();
        }

        if (!$data['slug'] = App::filter($data['slug'] ?: $data['title'], 'slugify')) {
            return App::jsonabort(400, __('Invalid slug.'));
        }

        // user without universal access is not allowed to assign posts to other users
        if(!App::user()->hasAccess('blog: manage all posts')) {
            $data['user_id'] = App::user()->id;
        }

        // user without universal access can only edit their own posts
        if(!App::user()->hasAccess('blog: manage all posts') && !App::user()->hasAccess('blog: manage own posts') && $category->user_id !== App::user()->id) {
            return App::jsonabort(400, __('Access denied.'));
        }

        $category->save($data);
        return compact('category');
    }

    /**
     * @Route("/{id}", methods="DELETE", requirements={"id"="\d+"})
     * @Request({"id": "int"}, csrf=true)
     * @param $id
     * @return string[]
     */
    public function deleteAction( int $id)
    {
        if ($category = Categories::find($id)) {

            if(!App::user()->hasAccess('blog: manage all posts') && !App::user()->hasAccess('blog: manage own posts') && $category->user_id !== App::user()->id) {
                App::jsonabort(400, __('Access denied.'));
            }

            $category->delete();
        }

        return ['message' => 'success'];
    }

    /**
     * @Route(methods="POST")
     * @Request({"ids": "int[]"}, csrf=true)
     * @param array $ids
     * @return string[]
     */
    public function copyAction( array $ids = [] )
    {
        foreach ($ids as $id) {
            if ($category = Categories::find((int) $id)) {
                if(!App::user()->hasAccess('blog: manage all posts') && !App::user()->hasAccess('blog: manage own posts') && $category->user_id !== App::user()->id) {
                    continue;
                }

                $category = clone $category;
                $category->id = null;
                $category->status = Categories::getStatus('STATUS_DRAFT');
                $category->title = $category->title.' - '.__('Copy');
                $category->date = new \DateTime;
                $category->save();
            }
        }

        return ['message' => 'success'];
    }

    /**
     * @Route("/bulk", methods="POST")
     * @Request({"categories": "array"}, csrf=true)
     * @param array $categories
     * @return string[]
     */
    public function bulkSaveAction( array $categories = [] )
    {
        foreach ($categories as $data) {
            $this->saveAction($data, isset($data['id']) ? $data['id'] : 0);
        }

        return ['message' => 'success'];
    }

    /**
     * @Route("/bulk", methods="DELETE")
     * @Request({"ids": "array"}, csrf=true)
     * @param array $ids
     * @return string[]
     */
    public function bulkDeleteAction( array $ids = [] )
    {
        foreach (array_filter($ids) as $id) {
            $this->deleteAction($id);
        }

        return ['message' => 'success'];
    }

}
