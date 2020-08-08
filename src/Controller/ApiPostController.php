<?php
namespace GreenCheap\Blog\Controller;

use GreenCheap\Application as App;
use GreenCheap\Blog\Model\Post;
use GreenCheap\Categories\Model\Categories;

/**
 * @Access("blog: manage own posts || blog: manage all posts")
 * @Route("post", name="post")
 * @Access(admin=true)
 */
class ApiPostController
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
        $query  = Post::query();
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

        $posts = array_values($query->offset($page * $limit)->related('user')->limit($limit)->orderBy($order[1], $order[2])->get());

        return compact('posts', 'pages', 'count');
    }

    /**
     * @Route("/", methods="POST")
     * @Route("/{id}", methods="POST", requirements={"id"="\d+"})
     * @Request({"data": "array", "id": "int"}, csrf=true)
     * @param array $data
     * @param int $id
     * @return array
     */
    public function saveAction( array $data, int $id = 0)
    {
        if (!$id || !$post = Post::find($id)) {

            if ($id) {
                App::abort(404, __('Post not found.'));
            }

            $post = Post::create();
        }

        if (!$data['slug'] = App::filter($data['slug'] ?: $data['title'], 'slugify')) {
            App::abort(400, __('Invalid slug.'));
        }

        // user without universal access is not allowed to assign posts to other users
        if(!App::user()->hasAccess('blog: manage all posts')) {
            $data['user_id'] = App::user()->id;
        }

        // user without universal access can only edit their own posts
        if(!App::user()->hasAccess('blog: manage all posts') && !App::user()->hasAccess('blog: manage own posts') && $post->user_id !== App::user()->id) {
            App::abort(400, __('Access denied.'));
        }

        $post->save($data);
        return ['message' => 'success', 'post' => $post];
    }

    /**
     * @Route("/{id}", methods="DELETE", requirements={"id"="\d+"})
     * @Request({"id": "int"}, csrf=true)
     * @param $id
     * @return string[]
     */
    public function deleteAction( int $id)
    {
        if ($post = Post::find($id)) {

            if(!App::user()->hasAccess('blog: manage all posts') && !App::user()->hasAccess('blog: manage own posts') && $post->user_id !== App::user()->id) {
                App::abort(400, __('Access denied.'));
            }

            $post->delete();
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
            if ($post = Post::find((int) $id)) {
                if(!App::user()->hasAccess('blog: manage all posts') && !App::user()->hasAccess('blog: manage own posts') && $post->user_id !== App::user()->id) {
                    continue;
                }

                $post = clone $post;
                $post->id = null;
                $post->status = Post::getStatus('STATUS_DRAFT');
                $post->title = $post->title.' - '.__('Copy');
                $post->date = App::date()->date;
                $post->save();
            }
        }

        return ['message' => 'success'];
    }

    /**
     * @Route("/bulk", methods="POST")
     * @Request({"posts": "array"}, csrf=true)
     * @param array $posts
     * @return string[]
     */
    public function bulkSaveAction( array $posts = [] )
    {
        foreach ($posts as $data) {
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
?>
