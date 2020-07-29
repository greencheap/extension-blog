<?php
namespace GreenCheap\Blog\Controller;

use GreenCheap\Application as App;
use GreenCheap\Blog\Model\Post;
use GreenCheap\Module\Module;

class SiteController
{
    /**
     * @var Module
     */
    protected $blog;

    protected $date;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->blog = App::module('blog');
        $this->date = new \DateTime;
    }

    /**
     * @Route("/")
     * @Route("/page/{page}", name="page", requirements={"page" = "\d+"})
     * @param int $page
     * @return array
     */
    public function indexAction( int $page = 1 )
    {
        $query = Post::where(['status = ?', 'date < ?'], [Post::getStatus('STATUS_PUBLISHED'), $this->date->format('Y-m-d h:m:s')])->where(function ($query) {
            return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
        })->related('user');

        if (!$limit = $this->blog->config('posts.posts_per_page')) {
            $limit = 10;
        }

        $count = $query->count('id');
        $total = ceil($count / $limit);
        $page = max(1, min($total, $page));

        $query->offset(($page - 1) * $limit)->limit($limit)->orderBy('date', 'DESC');

        foreach ($posts = $query->get() as $post) {
            $post->excerpt = App::content()->applyPlugins($post->excerpt, ['post' => $post, 'markdown' => $post->get('markdown')]);
            $post->content = App::content()->applyPlugins($post->content, ['post' => $post, 'markdown' => $post->get('markdown'), 'readmore' => true]);
        }

        return [
            '$view' => [
                'title' => __('Blog'),
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
            'page' => $page
        ];
    }

    /**
     * @Route("/feed")
     * @Route("/feed/{type}")
     * @param string $type
     * @return
     */
    public function feedAction( string $type = '' )
    {
        // fetch locale and convert to ISO-639 (en_US -> en-us)
        $locale = App::module('system')->config('site.locale');
        $locale = str_replace('_', '-', strtolower($locale));

        $site = App::module('system/site');
        $feed = App::feed()->create($type ?: $this->blog->config('feed.type'), [
            'title' => $site->config('title'),
            'link' => App::url('@blog', [], 0),
            'description' => $site->config('description'),
            'element' => ['language', $locale],
            'selfLink' => App::url('@blog/feed', [], 0)
        ]);

        if ($last = Post::where(['status = ?', 'date < ?'], [Post::getStatus('STATUS_PUBLISHED'), $this->date->format('Y-m-d h:m:s')])->limit(1)->orderBy('modified', 'DESC')->first()) {
            $feed->setDate($last->modified);
        }

        foreach (Post::where(['status = ?', 'date < ?'], [Post::getStatus('STATUS_PUBLISHED'), $this->date->format('Y-m-d h:m:s')])->where(function ($query) {
            return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
        })->related('user')->limit($this->blog->config('feed.limit'))->orderBy('date', 'DESC')->get() as $post) {
            $url = App::url('@blog/id', ['id' => $post->id], 0);
            $feed->addItem(
                $feed->createItem([
                    'title' => $post->title,
                    'link' => $url,
                    'description' => App::content()->applyPlugins($post->content, ['post' => $post, 'markdown' => $post->get('markdown'), 'readmore' => true]),
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
        if (!$post = Post::where(['id = ?', 'status = ?', 'date < ?'], [$id, Post::getStatus('STATUS_PUBLISHED'), $this->date->format('Y-m-d h:m:s')])->related('user')->first()) {
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
