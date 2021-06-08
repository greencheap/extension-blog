<?php

namespace GreenCheap\Blog\Sitemaps;

use GreenCheap\Application as App;
use GreenCheap\Blog\Model\Post;
use GreenCheap\Seo\SitemapInterface;

/**
 * Class BlogSitemap
 * @package GreenCheap\Seo\Sitemaps
 */
class BlogSitemap implements SitemapInterface
{
    /**
     * @var \DateTime
     */
    protected \DateTime $date;

    /**
     * NodeSitemap constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime;
    }

    /**
     * @param int $page
     * @return array
     */
    public function getData($page = 0): array
    {
        $data = [];

        if (!$page) {
            $query = Post::query()->where(['status = :status', 'date < :date'], ['status' => Post::getStatus('STATUS_PUBLISHED'), 'date' => new \DateTime])->where(function ($query) {
                return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
            });

            $limit = 50;

            $count = $query->count('id');
            $total = ceil($count / $limit);
            for ($i = 1; $i <= $total; $i++) {
                $data[] = [
                    'url' => [
                        'loc' => App::url('@sitemap/page', ['sitemap' => 'blog', 'page' => $i], 0),
                        'lastmod' => $this->date->format('Y-m-d')
                    ]
                ];
            }
        } else if ($page && $page > 0) {
            $query = \GreenCheap\Blog\Model\Post::query()->where(['status = :status', 'date < :date'], ['status' => \GreenCheap\Blog\Model\Post::getStatus('STATUS_PUBLISHED'), 'date' => new \DateTime])->where(function ($query) {
                return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
            });

            $limit = 50;

            $count = $query->count('id');
            $total = ceil($count / $limit);
            $page = max(1, min($total, $page));

            $query->offset(($page - 1) * $limit)->limit($limit)->orderBy('date', 'DESC');
            foreach ($query->get() as $post) {
                $url = App::url('@blog/id', ['id' => $post->id], 0);
                $data[] = [
                    'url' => [
                        'loc' => $url,
                        'lastmod' => $post->date->format('Y-m-d'),
                    ]
                ];
            }
        }

        return $data;
    }
}
