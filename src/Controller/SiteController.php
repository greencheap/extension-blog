<?php
namespace GreenCheap\Blog\Controller;

use GreenCheap\Application as App;
use GreenCheap\Blog\Model\Post;
use GreenCheap\Module\Module;
use GreenCheap\Blog\Model\Categories;
use JetBrains\PhpStorm\ArrayShape;

class SiteController
{
    /**
     * @var Module
     */
    protected Module $blog;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->blog = App::module('blog');
    }

    /**
     * @Route("/")
     * @Route("/page/{page}", name="page", requirements={"page" = "\d+"})
     * @param int $page
     * @param array $filter
     * @return array
     */
    #[ArrayShape(['$view' => "array", 'blog' => "mixed", 'posts' => "mixed", 'total' => "float", 'page' => "mixed", 'page_link' => "mixed|string", 'page_params' => "array|mixed", 'category_data' => "array|object"])]
    public function indexAction(int $page = 1 , array $filter = [] ): array
    {
        $query = Post::query()->where(['status = :status', 'date < :date'], ['status' => Post::getStatus('STATUS_PUBLISHED'), 'date' => new \DateTime])->where(function ($query) {
            return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
        });

        $filter = array_merge(array_fill_keys(['category' , 'title' , 'description' , 'page_link' , 'page_params', 'category_data'], ''), $filter);
        extract($filter, EXTR_SKIP);

        if($category) {
            $query->where(function ($query) use ($category) {
                $query->whereInSet('categories_id', (int) $category);
            });
        }

        if (!$limit = $this->blog->config('posts.posts_per_page')) {
            $limit = 10;
        }

        $count = $query->count('id');
        $total = ceil($count / $limit);
        $page = max(1, min($total, $page));

        $query->offset(($page - 1) * $limit)->limit($limit)->orderBy('date', 'DESC')->related('user');

        foreach ($posts = $query->get() as $post) {
            $post->excerpt = App::content()->applyPlugins($post->excerpt, ['post' => $post, 'markdown' => $post->get('markdown')]);
            $post->content = App::content()->applyPlugins($post->content, ['post' => $post, 'markdown' => $post->get('markdown'), 'readmore' => true]);
        }

        return [
            '$view' => [
                'title' => $title ?: __('Blog'),
                'name' => 'blog/posts.php',
                'link:feed' => [
                    'rel' => 'alternate',
                    'href' => App::url('@blog/feed'),
                    'title' => App::module('system/site')->config('title'),
                    'type' => App::feed()->create($this->blog->config('feed.type'))->getMIMEType()
                ]
            ],
            'blog' => $this->blog,
            'posts' => $posts,
            'total' => $total,
            'page' => $page,
            'page_link' => $page_link ?: '@blog/page',
            'page_params' => $page_params ?: [],
            'category_data' => (object) $category_data ?: []
        ];
    }

    /**
     * @Route("/category/{id}", name="category/id")
     * @param int $id
     * @return mixed
     */
    public function categoryAction( int $id ): mixed
    {
        $request = App::request();
        $page = intval($request->query->get('page')) ?: 1;
        $query = Categories::query()->where(['status = :status', 'date < :date'], ['status' => Categories::getStatus('STATUS_PUBLISHED'), 'date' => new \DateTime])->where(function ($query) {
            return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
        });

        $query->where(['id = :id'], compact('id'));

        if(!$category = $query->related('user')->first()){
            return App::abort(404, __('Not Found Category'));
        }

        if($category->excerpt){
            $category->excerpt = App::content()->applyPlugins($category->excerpt, ['post' => $category, 'markdown' => $category->get('markdown')]);
        }

        return $this->indexAction($page, [
            'category' => $category->id,
            'title' => $category->title,
            'page_link' => '@blog/category/id',
            'page_params' => ['id' => $id],
            'category_data' => $category
        ]);
    }

    /**
     * @Route("/feed" , defaults={"_maintenance"=true})
     * @Route("/feed/{type}" , defaults={"_maintenance"=true})
     * @param string $type
     * @return mixed
     */
    public function feedAction( string $type = '' ): mixed
    {
        // fetch locale and convert to ISO-639 (en_US -> en-us)
        $locale = App::module('system')->config('site.locale');
        $locale = str_replace('_', '-', strtolower($locale));

        $site = App::module('system/site');
        $siteUrl = str_replace("/","\/",App::url("", [], 0));

        $feed = App::feed()->create($type ?: $this->blog->config('feed.type'), [
            'title' => $site->config('title'),
            'link' => App::url('@blog', [], 0),
            'description' => $site->config('description'),
            'element' => ['language', $locale],
            'selfLink' => App::url('@blog/feed', [], 0)
        ]);

        if ($last = Post::query()->where(['status = :status', 'date < :date'], ['status' => Post::getStatus('STATUS_PUBLISHED'), 'date' => new \DateTime])->limit(1)->orderBy('modified', 'DESC')->first()) {
            $feed->setDate($last->modified);
        }

        foreach (Post::query()->where(['status = :status', 'date < :date'], ['status' => Post::getStatus('STATUS_PUBLISHED'), 'date' => new \DateTime])->where(function ($query) {
            return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
        })->related('user')->limit($this->blog->config('feed.limit'))->orderBy('date', 'DESC')->get() as $post) {
            $url = App::url('@blog/id', ['id' => $post->id], 0);
            $image = preg_match("/https?:\/\/*/", $post->get('image.src')) ? $post->get('image.src') : App::url()->getStatic($post->get('image.src'), [], 0);
            $feed->addItem(
                $feed->createItem([
                    'title' => $post->title,
                    'link' => $url,
                    'thumbnail' => $image,
                    'description' => App::content()->applyPlugins($post->excerpt, ['post' => $post, 'markdown' => $post->get('markdown'), 'readmore' => true]),
                    'date' => $post->date,
                    'author' => [$post->user->name, $post->user->email],
                    'id' => $url
                ])
            );
        }

        return App::response($feed->output(), 200, ['Content-Type' => $feed->getMIMEType().'; charset='.$feed->getEncoding()]);
    }

    /**
     * @Route("/{id}", name="id")
     * @Captcha(route="@blog/api/comment/save")
     * @Captcha(route="@blog/api/comment/save_1")
     * @param int $id
     * @return array
     */
    public function postAction( int $id = 0 )
    {
        if (!$post = Post::query()->where(['id = :id', 'status = :status', 'date < :date'], ['id' => $id, 'status' => Post::getStatus('STATUS_PUBLISHED'), 'date' => new \DateTime])->related('user')->first()) {
            App::abort(404, __('Post not found!'));
        }

        if (!$post->hasAccess(App::user())) {
            App::abort(403, __('Insufficient User Rights.'));
        }

        $post->excerpt = App::content()->applyPlugins($post->excerpt, ['post' => $post, 'markdown' => $post->get('markdown')]);
        $post->content = App::content()->applyPlugins($post->content, ['post' => $post, 'markdown' => $post->get('markdown')]);

        $user = App::user();

        $description = $post->get('meta.og:description');
        if (!$description) {
            $description = strip_tags($post->excerpt ?: $post->content);
            $description = rtrim(mb_substr($description, 0, 150), " \t\n\r\0\x0B.,") . '...';
        }

        return [
            '$view' => [
                'title' => __($post->title),
                'name' => 'blog/post.php',
                'og:type' => 'article',
                'article:published_time' => $post->date->format(\DateTime::ATOM),
                'article:modified_time' => $post->modified->format(\DateTime::ATOM),
                'article:author' => $post->user->name,
                'og:title' => $post->get('meta.og:title') ?: $post->title,
                'og:description' => $description,
                'og:image' =>  $post->get('image.src') ? App::url()->getStatic($post->get('image.src'), [], 0) : false
            ],
            'blog' => $this->blog,
            'post' => $post
        ];
    }
}
